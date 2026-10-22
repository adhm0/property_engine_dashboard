<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Phar;
use PharData;
use RuntimeException;

class SchemaExcelExporter
{
    protected array $tableOrder = [
        'countries',
        'cities',
        'districts',
        'property_types',
        'property_classifications',
        'property_type_classifications',
        'properties',
        'property_rules',
        'bookable_unit_types',
        'bookable_units',
        'attribute_groups',
        'attribute_definitions',
        'attribute_options',
        'unit_type_attributes',
        'bookable_unit_attribute_values',
        'languages',
        'translations',
    ];

    protected array $excludedTables = [
        'cache',
        'cache_locks',
        'failed_jobs',
        'job_batches',
        'jobs',
        'migrations',
        'password_reset_tokens',
        'personal_access_tokens',
        'sessions',
        'users',
    ];

    protected array $excludedColumns = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $fillColors = [
        '0D9488',
        '4F46E5',
        '1E293B',
        '0369A1',
        '9333EA',
        'BE123C',
        '475569',
    ];

    public function export(): string
    {
        $builder = DB::connection()->getSchemaBuilder();

        $tables = collect($builder->getTables())
            ->pluck('name')
            ->reject(fn (string $table): bool => in_array($table, $this->excludedTables, true))
            ->sortBy(fn (string $table): int => $this->tableSortIndex($table))
            ->values();

        $sheets = [];

        foreach ($tables as $table) {
            $columns = collect($builder->getColumns($table))
                ->reject(fn (array $column): bool => in_array($column['name'], $this->excludedColumns, true))
                ->values();

            $columnNames = $columns->pluck('name')->all();

            $rows = $columnNames === []
                ? collect()
                : DB::table($table)->get($columnNames);

            $sheets[] = [
                'name' => Str::studly(Str::singular($table)),
                'columns' => $columns,
                'rows' => $rows,
                'style' => $this->headerStyleIndex($table),
            ];
        }

        if ($sheets === []) {
            $sheets[] = [
                'name' => 'No tables',
                'columns' => collect(),
                'rows' => collect(),
                'style' => 7,
            ];
        }

        return $this->writeWorkbook($sheets);
    }

    protected function tableSortIndex(string $table): int
    {
        $index = array_search($table, $this->tableOrder, true);

        return $index === false ? count($this->tableOrder) : $index;
    }

    protected function headerStyleIndex(string $table): int
    {
        return match ($table) {
            'countries', 'cities', 'districts' => 1,
            'property_types', 'property_classifications', 'property_type_classifications' => 2,
            'properties', 'property_rules' => 3,
            'bookable_unit_types', 'bookable_units' => 4,
            'attribute_groups', 'attribute_definitions', 'attribute_options',
            'unit_type_attributes', 'bookable_unit_attribute_values' => 5,
            'languages', 'translations' => 6,
            default => 7,
        };
    }

    protected function writeWorkbook(array $sheets): string
    {
        $temporaryFile = tempnam(sys_get_temp_dir(), 'schema_');

        if ($temporaryFile === false) {
            throw new RuntimeException('Unable to create a temporary file for the schema export.');
        }

        @unlink($temporaryFile);

        $archivePath = $temporaryFile.'.zip';

        $archive = new PharData($archivePath, 0, null, Phar::ZIP);

        $archive->addFromString('[Content_Types].xml', $this->contentTypesXml($sheets));
        $archive->addFromString('_rels/.rels', $this->rootRelationshipsXml());
        $archive->addFromString('xl/workbook.xml', $this->workbookXml($sheets));
        $archive->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelationshipsXml($sheets));
        $archive->addFromString('xl/styles.xml', $this->stylesXml());

        foreach ($sheets as $index => $sheet) {
            $archive->addFromString(
                'xl/worksheets/sheet'.($index + 1).'.xml',
                $this->worksheetXml($sheet['columns'], $sheet['rows'], $sheet['style']),
            );
        }

        unset($archive);

        $this->normaliseArchiveVersion($archivePath);

        return $archivePath;
    }

    protected function contentTypesXml(array $sheets): string
    {
        $worksheetOverrides = '';

        foreach (array_keys($sheets) as $index) {
            $worksheetOverrides .= '<Override PartName="/xl/worksheets/sheet'.($index + 1).'.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>'
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            .$worksheetOverrides
            .'</Types>';
    }

    protected function rootRelationshipsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            .'</Relationships>';
    }

    protected function workbookXml(array $sheets): string
    {
        $sheetNodes = '';

        foreach (array_keys($sheets) as $index) {
            $sheetNodes .= '<sheet name="'.$this->escape($sheets[$index]['name']).'" sheetId="'.($index + 1).'" r:id="rId'.($index + 1).'"/>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets>'.$sheetNodes.'</sheets>'
            .'</workbook>';
    }

    protected function workbookRelationshipsXml(array $sheets): string
    {
        $relationships = '';

        foreach (array_keys($sheets) as $index) {
            $relationships .= '<Relationship Id="rId'.($index + 1).'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet'.($index + 1).'.xml"/>';
        }

        $relationships .= '<Relationship Id="rId'.(count($sheets) + 1).'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .$relationships
            .'</Relationships>';
    }

    protected function stylesXml(): string
    {
        $headerFonts = '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/><family val="2"/></font>';

        $fills = '<fill><patternFill patternType="none"/></fill>'
            .'<fill><patternFill patternType="gray125"/></fill>';

        foreach ($this->fillColors as $color) {
            $fills .= '<fill><patternFill patternType="solid"><fgColor rgb="FF'.$color.'"/><bgColor indexed="64"/></patternFill></fill>';
        }

        $cellFormats = '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>';

        foreach (array_keys($this->fillColors) as $index) {
            $fillId = $index + 2;

            $cellFormats .= '<xf numFmtId="0" fontId="1" fillId="'.$fillId.'" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>';
        }

        $cellFormats .= '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment horizontal="left" vertical="center"/></xf>';

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<fonts count="2">'
            .'<font><sz val="11"/><color rgb="FF000000"/><name val="Calibri"/><family val="2"/></font>'
            .$headerFonts
            .'</fonts>'
            .'<fills count="'.(count($this->fillColors) + 2).'">'.$fills.'</fills>'
            .'<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            .'<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            .'<cellXfs count="'.(count($this->fillColors) + 2).'">'.$cellFormats.'</cellXfs>'
            .'<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            .'<dxfs count="0"/>'
            .'</styleSheet>';
    }

    protected function worksheetXml($columns, $rows, int $headerStyle): string
    {
        $headerCells = '';

        foreach ($columns as $index => $column) {
            $reference = $this->columnLetter($index + 1).'1';
            $header = Str::camel($column['name']);

            $headerCells .= '<c r="'.$reference.'" s="'.$headerStyle.'" t="inlineStr"><is><t xml:space="preserve">'
                .$this->escape($header)
                .'</t></is></c>';
        }

        $rowNodes = '<row r="1" ht="32" customHeight="1">'.$headerCells.'</row>';

        $columnKinds = [];

        foreach ($columns as $column) {
            $columnKinds[$column['name']] = $this->columnKind($column);
        }

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2;
            $cells = '';

            foreach ($columns as $index => $column) {
                $value = $row->{$column['name']} ?? null;

                $cells .= $this->dataCellXml(
                    $this->columnLetter($index + 1).$rowNumber,
                    $value,
                    $columnKinds[$column['name']],
                );
            }

            $rowNodes .= '<row r="'.$rowNumber.'">'.$cells.'</row>';
        }

        $columnNodes = '';

        foreach ($columns as $index => $column) {
            $width = $this->columnWidth(Str::camel($column['name']), $column['name'], $rows);

            $columnNodes .= '<col min="'.($index + 1).'" max="'.($index + 1).'" width="'.$width.'" customWidth="1"/>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/><selection pane="bottomLeft" activeCell="A2" sqref="A2"/></sheetView></sheetViews>'
            .'<sheetFormatPr defaultRowHeight="15"/>'
            .($columnNodes !== '' ? '<cols>'.$columnNodes.'</cols>' : '')
            .'<sheetData>'.$rowNodes.'</sheetData>'
            .'</worksheet>';
    }

    protected function dataCellXml(string $reference, mixed $value, string $kind): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        if ($kind === 'boolean') {
            $boolean = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $boolean ??= (bool) $value;

            return '<c r="'.$reference.'" s="8" t="b"><v>'.($boolean ? '1' : '0').'</v></c>';
        }

        if ($kind === 'number' && is_numeric($value)) {
            return '<c r="'.$reference.'" s="8"><v>'.$this->numberString($value).'</v></c>';
        }

        return '<c r="'.$reference.'" s="8" t="inlineStr"><is><t xml:space="preserve">'
            .$this->escape($this->stringify($value))
            .'</t></is></c>';
    }

    protected function columnKind(array $column): string
    {
        $type = strtolower(($column['type_name'] ?? '').' '.($column['type'] ?? ''));

        if (str_contains($type, 'bool') || str_contains($type, 'tinyint(1)')) {
            return 'boolean';
        }

        if (preg_match('/\b(int2|int4|int8|smallint|integer|bigint|serial|bigserial|numeric|decimal|real|float4|float8|double|float|money|oid)\b/', $type) === 1) {
            return 'number';
        }

        return 'string';
    }

    protected function numberString(mixed $value): string
    {
        if (is_int($value)) {
            return (string) $value;
        }

        $formatted = rtrim(rtrim(number_format((float) $value, 10, '.', ''), '0'), '.');

        return $formatted === '' || $formatted === '-' ? '0' : $formatted;
    }

    protected function columnWidth(string $header, string $columnName, $rows): float
    {
        $width = mb_strlen($header);

        foreach ($rows as $row) {
            $width = max($width, mb_strlen($this->stringify($row->{$columnName} ?? '')));
        }

        return max(14, min(50, $width + 2));
    }

    protected function stringify(mixed $value): string
    {
        return match (true) {
            $value === null => '',
            is_bool($value) => $value ? 'True' : 'False',
            is_array($value) => (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            $value instanceof \DateTimeInterface => $value->format('Y-m-d H:i:s'),
            default => (string) $value,
        };
    }

    protected function escape(string $value): string
    {
        $value = (string) preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    protected function columnLetter(int $number): string
    {
        $letters = '';

        while ($number > 0) {
            $number--;
            $letters = chr(65 + ($number % 26)).$letters;
            $number = intdiv($number, 26);
        }

        return $letters;
    }

    protected function normaliseArchiveVersion(string $path): void
    {
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException('Unable to read the generated schema workbook.');
        }

        $length = strlen($contents);
        $offset = 0;

        while ($offset + 30 <= $length && substr($contents, $offset, 4) === "PK\x03\x04") {
            $header = unpack(
                'vversion/vflags/vmethod/vtime/vdate/Vcrc/Vcompressed/Vuncompressed/vnamelen/vextralen',
                substr($contents, $offset + 4, 26),
            );

            $contents = substr_replace($contents, pack('v', 20), $offset + 4, 2);

            $offset += 30 + $header['namelen'] + $header['extralen'] + $header['compressed'];
        }

        $endOfCentralDirectory = strrpos($contents, "PK\x05\x06");

        if ($endOfCentralDirectory === false) {
            throw new RuntimeException('The generated schema workbook has an invalid ZIP structure.');
        }

        $directory = unpack(
            'vdisk/vcddisk/vdiskentries/ventries/Vcdsize/Vcdoffset/vcommentlen',
            substr($contents, $endOfCentralDirectory + 4, 18),
        );

        $offset = $directory['cdoffset'];

        while ($offset + 46 <= $length && substr($contents, $offset, 4) === "PK\x01\x02") {
            $header = unpack(
                'vversionmade/vversionneeded/vflags/vmethod/vtime/vdate/Vcrc/Vcompressed/Vuncompressed/vnamelen/vextralen/vcommentlen/vdisk/vinternal/Vexternal/Vlocaloffset',
                substr($contents, $offset + 4, 42),
            );

            $contents = substr_replace($contents, pack('v', 20), $offset + 4, 2);
            $contents = substr_replace($contents, pack('v', 20), $offset + 6, 2);

            $offset += 46 + $header['namelen'] + $header['extralen'] + $header['commentlen'];
        }

        file_put_contents($path, $contents);
    }
}
