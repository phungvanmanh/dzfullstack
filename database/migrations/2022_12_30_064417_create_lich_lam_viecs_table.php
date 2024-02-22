<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lich_lam_viecs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien')->index();
            $table->date('ngay_lam_viec');
            $table->integer('buoi_lam_viec')->comment('1: Sáng, 2: Chiều, 3: Tối, 4: Khuya')->index();
            $table->longText('noi_dung_buoi')->nullable();
            $table->integer('danh_gia')->comment('Đánh giá từ 0 đến 100')->default(0);
            $table->longText('noi_dung_buoi_danh_gia')->nullable();
            $table->integer('id_nguoi_danh_gia')->nullable()->index();
            $table->integer('is_trang_thai')->comment('1: đi làm, 2: Sup, 3: đi làm + Sup')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lich_lam_viecs');
    }
};
