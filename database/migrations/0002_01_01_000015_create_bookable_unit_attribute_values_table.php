<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookable_unit_attribute_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('unit_id')->constrained('bookable_units')->onDelete('cascade');
            $table->foreignUuid('attribute_id')->constrained('attribute_definitions')->onDelete('cascade');
            $table->text('value_string')->nullable();
            $table->decimal('value_number', 18, 2)->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->timestamp('value_date')->nullable();
            $table->jsonb('value_json')->nullable();
            $table->foreignUuid('option_id')->nullable()->constrained('attribute_options')->onDelete('cascade');
            $table->unique(['unit_id', 'attribute_id'], 'bookable_unit_attr_value_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookable_unit_attribute_values');
    }
};
