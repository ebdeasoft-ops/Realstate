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
        Schema::create('lease_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('tenant_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent_amount', 10, 2);
            $table->string('contract_number', 255)->nullable()->default('.');
            $table->string('contract_type', 255)->nullable()->default('.');
            $table->string('electricity_meter', 255)->nullable()->default('.');
            $table->date('contract_date')->nullable();
            $table->integer('payment_every')->nullable()->default(6);
            $table->decimal('installment_amount', 10, 2)->nullable()->default(0.00);
            $table->decimal('commission', 10, 2)->nullable()->default(0.00);
            $table->decimal('annual_commission', 10, 2)->nullable()->default(0.00);
            $table->decimal('water_bill', 10, 2)->nullable()->default(0.00);
            $table->decimal('paid_amount', 10, 2)->nullable()->default(0.00);
            $table->string('represented_by', 255)->nullable()->default('.');
            $table->string('guarantor_name', 255)->nullable()->default('.');
            $table->string('guarantor_phone', 255)->nullable()->default('.');
            $table->text('notes')->nullable();
            $table->text('insurance_amount')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_contracts');
    }
};
