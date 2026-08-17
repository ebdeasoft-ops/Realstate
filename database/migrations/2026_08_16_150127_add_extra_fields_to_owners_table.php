<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->string('nationality')->nullable();          // الجنسية
            $table->string('national_id')->nullable();          // رقم الهوية
            $table->string('bank_name')->nullable();            // اسم البنك
            $table->string('bank_account_number')->nullable();  // رقم الحساب
            $table->string('iban')->nullable();                 // رقم الآيبان
        });
    }

    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn([
                'nationality', 
                'national_id', 
                'bank_name', 
                'bank_account_number', 
                'iban'
            ]);
        });
    }
};