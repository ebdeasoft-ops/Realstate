<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('unit_number', 255);
            $table->string('unit_category', 255)->nullable();
            $table->string('finishing_type', 255)->nullable();
            $table->decimal('annual_rent', 10, 2);
            $table->string('payment_method', 255)->nullable();
            $table->string('floor_number', 255)->nullable();
            $table->integer('rooms_count')->nullable();
            $table->integer('kitchens_count')->nullable();
            $table->integer('bathrooms_count')->nullable();
            $table->string('ac_status', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_rented')->default(0);
            $table->string('status', 50)->nullable();
            $table->string('electricity_meter', 255)->nullable();
            $table->string('water_meter', 255)->nullable();
            $table->integer('ac_count')->nullable();
            $table->index(['property_id'], 'units_property_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
