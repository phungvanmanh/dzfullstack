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
        Schema::create('lich_hocs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_buoi_hoc')->index();
            $table->integer('id_hoc_vien')->index();
            $table->integer('tinh_trang')->default(0)->comment('0: Chưa điểm danh, 1: Có đi học, 2: Vắng Có Phép, 3: Vắng Không Phép')->index();
            $table->string('ly_do_vang')->comment('Điền Lý Do Vắng Ở Đây')->nullable();
            $table->integer('danh_gia_bai_tap')->nullable()->comment('Null là không có bài tập. Còn lại cho điểm từ 0 đến 100')->index();
            $table->integer('id_nhan_vien_danh_gia')->nullable()->comment('Nhân viên nào đánh giá')->index();
            $table->integer('hoc_vien_danh_gia_buoi_hoc')->nullable()->comment('Điểm học viên đánh giá buổi học')->index();
            $table->string('noi_dung_danh_gia')->nullable()->comment('Nội dung đánh giá buổi học');
            $table->string('anh_minh_chung')->nullable()->comment('Hình ảnh khi vắng học có phép');
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
        Schema::dropIfExists('lich_hocs');
    }
};
