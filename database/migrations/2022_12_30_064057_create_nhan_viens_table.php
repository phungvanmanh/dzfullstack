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
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->index();
            $table->string('ho_va_ten')->index();
            $table->string('password');
            $table->string('so_dien_thoai')->index();
            $table->string('facebook')->index();
            $table->date('ngay_bat_dau_lam');
            $table->integer('is_open')->default(1)->index();
            $table->string('anh_dai_dien')->nullable();
            $table->integer('id_quyen')->default(0)->index();
            $table->date('ngay_sinh');
            $table->string('ten_goi_nho');
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
        Schema::dropIfExists('nhan_viens');
    }
};
