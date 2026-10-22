<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('property_type_classification_id')->constrained('property_type_classifications')->onDelete('restrict');
            $table->foreignUuid('district_id')->constrained('districts')->onDelete('restrict');
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->enum('status', ['PENDING', 'ACTIVE', 'MAINTENANCE', 'REJECTED', 'INACTIVE'])->default('PENDING');
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('landmark')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
