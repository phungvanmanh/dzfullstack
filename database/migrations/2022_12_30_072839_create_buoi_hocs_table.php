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
        Schema::create('buoi_hocs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_lop_hoc');
            $table->integer('thu_tu_buoi_khoa_hoc')->comment("Buổi thứ mấy trong khoá")->index();
            $table->string('link_video')->nullable()->index();
            $table->string('link_notepad')->nullable()->index();
            $table->dateTime('gio_bat_dau')->index();
            $table->dateTime('gio_ket_thuc')->index();
            $table->integer('id_nhan_vien_day')->comment('ten_nguoi_day_buoi_nay')->index();
            $table->integer('is_bai_tap')->default(0)->comment('0: Không có bài tập, 1: Có bài tập')->index();
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
        Schema::dropIfExists('buoi_hocs');
    }
};
