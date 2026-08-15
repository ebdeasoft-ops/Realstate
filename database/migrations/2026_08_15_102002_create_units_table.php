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
    Schema::create('units', function (Blueprint $table) {
        $table->id();
        $table->foreignId('property_id')->constrained('properties');
        $table->string('unit_number');
        $table->decimal('annual_rent', 10, 2);
        $table->boolean('is_rented')->default(false);
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
        Schema::dropIfExists('units');
    }
};
