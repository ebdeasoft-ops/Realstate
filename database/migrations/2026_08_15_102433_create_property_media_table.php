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
    Schema::create('property_media', function (Blueprint $table) {
        $table->id();
        $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
        $table->string('file_path'); // مسار الملف المخزن
        $table->enum('file_type', ['image', 'video']); // لتحديد النوع
        $table->string('description')->nullable(); // وصف للصورة (مثلاً: واجهة العمارة)
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
        Schema::dropIfExists('property_media');
    }
};
