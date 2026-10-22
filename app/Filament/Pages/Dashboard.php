<?php

namespace App\Filament\Pages;

use App\Support\SchemaExcelExporter;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadDatabaseSchema')
                ->label('تحميل مخطط قاعدة البيانات (Excel)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->tooltip('تنزيل ملف Excel يحتوي على ورقة لكل جدول في قاعدة البيانات')
                ->action(function () {
                    $path = app(SchemaExcelExporter::class)->export();

                    return response()->download(
                        $path,
                        'database-schema-'.now()->format('Y-m-d_H-i-s').'.xlsx',
                        ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                    )->deleteFileAfterSend(true);
                }),
        ];
    }
}
