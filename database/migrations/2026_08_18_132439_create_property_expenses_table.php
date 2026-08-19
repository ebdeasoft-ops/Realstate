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
 public function up(): void
{
Schema::create('property_expenses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('property_id')->constrained()->onDelete('cascade');
    $table->string('expense_type');
    $table->decimal('amount', 10, 2);
    $table->date('expense_date');
    
    // إضافة حقل طريقة الدفع
    $table->string('payment_method')->default('cash'); // خيارات: cash, bank_transfer, check
    
    $table->text('description')->nullable();
    $table->string('receipt_path')->nullable();
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
        Schema::dropIfExists('property_expenses');
    }
};
