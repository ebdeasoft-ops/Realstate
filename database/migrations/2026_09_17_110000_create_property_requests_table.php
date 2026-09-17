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
        Schema::create('property_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email')->nullable();
            $table->string('national_id')->nullable();

            // نوع الطلب: rent (إيجار) أو sale (شراء / تملك)
            $table->string('request_type')->default('rent');

            // نوع العقار / الوحدة (شقة، فيلا، عمارة...) مرتبط بـ unit_types
            $table->unsignedBigInteger('unit_type_id')->nullable();

            // الموقع المستهدف
            $table->string('city')->nullable();
            $table->string('district')->nullable();

            // الميزانية المتوقعة
            $table->decimal('min_price', 12, 2)->nullable();
            $table->decimal('max_price', 12, 2)->nullable();

            // المواصفات المطلوبة
            $table->integer('rooms_count')->nullable();
            $table->integer('bathrooms_count')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('finishing_type')->nullable();
            $table->string('ac_status')->nullable();
            $table->text('notes')->nullable();

            // حالة الطلب ومتابعة التواصل
            // pending: قيد الانتظار, contacted: تم التواصل, fulfilled: تم توفير العقار, cancelled: ملغي
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('matched_unit_id')->nullable();
            $table->unsignedBigInteger('matched_property_id')->nullable();
            $table->text('contact_notes')->nullable();
            $table->timestamp('last_contacted_at')->nullable();

            // الموظف المنشئ
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // الفهارس
            $table->index('status');
            $table->index('request_type');
            $table->index('unit_type_id');
            $table->index('city');
            $table->index('client_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_requests');
    }
};
