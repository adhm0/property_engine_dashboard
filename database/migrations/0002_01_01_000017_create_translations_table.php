<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('entity_type', ['COUNTRY', 'CITY', 'DISTRICT', 'PROPERTY', 'BOOKABLE_UNIT', 'PROPERTY_RULE', 'ATTRIBUTE_GROUP', 'ATTRIBUTE_DEFINITION', 'ATTRIBUTE_OPTION', 'UI_LABEL', 'HOME_SECTION']);
            $table->uuid('entity_id');
            $table->string('field', 80);
            $table->string('language_code', 10);
            $table->foreign('language_code')->references('code')->on('languages')->onDelete('cascade');
            $table->text('value');
            $table->unique(['entity_type', 'entity_id', 'field', 'language_code'], 'translation_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
