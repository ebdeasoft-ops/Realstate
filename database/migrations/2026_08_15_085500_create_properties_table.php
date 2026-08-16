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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('property_category', 255)->nullable();
            $table->string('name', 255);
            $table->string('address', 255)->nullable();
            $table->string('city', 255);
            $table->string('district', 255);
            $table->decimal('commission_rate', 5, 2)->default(0.00);
            $table->string('type', 50)->nullable();
            $table->decimal('annual_rent', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('owner_id_number', 100)->nullable();
            $table->string('owner_nationality', 100)->nullable();
            $table->string('owner_phone', 100)->nullable();
            $table->string('owner_landline', 100)->nullable();
            $table->string('owner_address', 255)->nullable();
            $table->string('owner_email', 255)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('account_number', 255)->nullable();
            $table->string('iban', 255)->nullable();
            $table->string('insurance_account', 100)->nullable();
            $table->string('water_account', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
