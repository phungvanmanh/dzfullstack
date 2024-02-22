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
        Schema::create('hoc_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten')->index();
            $table->string('ho_lot')->index();
            $table->string('ten')->index();
            $table->string('email')->index();
            $table->string('name_zalo')->nullable()->index();
            $table->string('so_dien_thoai')->nullable();
            $table->string('sologan')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->longText('mo_ta_trinh_do')->nullable();
            $table->string('nguoi_gioi_thieu')->nullable();
            $table->integer('id_nhan_vien_ref')->nullable()->index();
            $table->integer('id_nhan_vien_support')->nullable()->index();
            $table->string('danh_sach_teamview')->nullable();
            $table->string('tai_khoan_git')->nullable();
            $table->string('id_lop_dang_ky')->index();
            $table->integer('is_hoc_vien')->default(0)->index();
            $table->string('uuid')->index();
            $table->string('password');
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
        Schema::dropIfExists('hoc_viens');
    }
};
