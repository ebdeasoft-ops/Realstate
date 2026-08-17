<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('rent_installments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('contract_id')->constrained('lease_contracts')->onDelete('cascade');
        $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
        $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
        
        $table->integer('installment_number'); // رقم القسط (1، 2، 3...)
        $table->decimal('amount', 15, 2);      // قيمة القسط
        $table->date('due_date');              // تاريخ استحقاق القسط
        $table->date('paid_date')->nullable(); // تاريخ السداد الفعلي
        $table->enum('status', ['paid', 'unpaid', 'partially_paid', 'cancelled'])->default('unpaid');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_installments');
    }
};
