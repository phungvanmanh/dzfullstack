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
        Schema::create('hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien')->index();
            $table->integer('id_lop_hoc')->index();
            $table->integer('thang_hoc')->comment("Tháng học của lớp")->index();
            $table->integer('tinh_trang')->default(0)->comment('0: Chưa nộp học phí, 1: Xin Trễ, 2: Đã Nộp')->index();
            $table->text('ghi_chu')->nullable()->comment('Ghi chú về học phí');
            $table->integer('so_tien_nop')->default(0)->index();
            $table->integer('is_con_hoc')->default(0)->comment('1: Còn Học, 0: Bỏ học')->index();
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
        Schema::dropIfExists('hoc_phis');
    }
};
