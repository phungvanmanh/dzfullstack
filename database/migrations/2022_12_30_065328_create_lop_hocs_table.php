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
        Schema::create('lop_hocs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_khoa_hoc')->index();
            $table->integer('id_nhan_vien_day')->comment('Tên người dạy lớp này')->index();
            $table->string('ten_lop_hoc')->index();
            $table->date('ngay_bat_dau_hoc');
            $table->integer('is_mo_dang_ky')->default(0)->index()->comment('0: Chưa mở đăng ký, 1: Mở đăng ký');
            $table->string('link_driver_lop_hoc')->nullable();
            $table->string('link_zalo_lop')->nullable();
            $table->string('link_facebook_lop')->nullable();
            $table->longText('mo_ta_khoa')->nullable();
            $table->string('thu_trong_tuan')->comment('Ví dụ: 2,4,6');
            $table->integer('so_thang_hoc')->comment('Thường là 3 tháng')->default(3);
            $table->integer('hoc_phi_theo_thang')->default(2500000);
            $table->integer('so_buoi_trong_thang')->default(12)->index();
            $table->integer('is_done')->default(0)->index();
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
        Schema::dropIfExists('lop_hocs');
    }
};
