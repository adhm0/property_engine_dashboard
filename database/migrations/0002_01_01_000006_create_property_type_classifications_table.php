<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_type_classifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('property_type_id')->constrained('property_types')->onDelete('cascade');
            $table->foreignUuid('classification_id')->constrained('property_classifications')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->unique(['property_type_id', 'classification_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_type_classifications');
    }
};
