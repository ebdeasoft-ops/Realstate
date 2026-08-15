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
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->foreignId('owner_id')->constrained('owners');
        $table->string('name');
        $table->string('city');
        $table->string('district');
        $table->decimal('commission_rate', 5, 2)->default(0); // نسبة العمولة
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
        Schema::dropIfExists('properties');
    }
};
