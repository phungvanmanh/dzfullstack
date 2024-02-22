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
        Schema::create('danh_gia_ren_luyens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sinh_vien')->index();
            $table->string('ho_va_ten')->index();
            $table->string('ho_lot')->index();
            $table->string('ten_sinh_vien')->index();
            $table->string('dien_thoai')->index();
            $table->string('dia_chi')->index();
            $table->string('email')->index();
            $table->string('nganh_hoc')->index();
            $table->string('id_sinh_vien')->index();
            $table->string('ky_hoc')->index();
            $table->string('id_ky_hoc')->index();
            $table->double('diem_tich_luy', 6, 2)->index();
            $table->string('xep_loai')->index();
            $table->string('diem_quy_doi')->index();
            $table->string('id_giang_vien')->index();
            $table->integer('is_done')->default(0)->index()->comment('0: Chưa xong, 1: Xong');
            $table->integer('status_student')->default(0)->index()->comment('0: Sinh viên chưa đánh giá, 1: Sinh viên chưa khai báo, 2: Trạng thái oke');
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
        Schema::dropIfExists('danh_gia_ren_luyens');
    }
};
