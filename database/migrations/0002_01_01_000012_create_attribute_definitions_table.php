<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_definitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('key', 80)->unique();
            $table->enum('value_type', ['TEXT', 'NUMBER', 'BOOLEAN', 'ENUM', 'DATE', 'JSON']);
            $table->foreignUuid('group_id')->constrained('attribute_groups')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('unit_code', 30)->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('is_displayable')->default(true);
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_definitions');
    }
};
