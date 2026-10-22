<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_type_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('unit_type_id')->constrained('bookable_unit_types')->onDelete('cascade');
            $table->foreignUuid('attribute_id')->constrained('attribute_definitions')->onDelete('cascade');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_displayable')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unique(['unit_type_id', 'attribute_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_type_attributes');
    }
};
