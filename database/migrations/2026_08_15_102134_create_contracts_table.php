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
    Schema::create('lease_contracts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('unit_id')->constrained('units');
        $table->foreignId('tenant_id')->constrained('tenants');
        $table->date('start_date');
        $table->date('end_date');
        $table->decimal('rent_amount', 10, 2);
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
        Schema::dropIfExists('contracts');
    }
};
