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
        Schema::create('giao_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_giao');
            $table->string('list_nhan');
            $table->text('tieu_de');
            $table->dateTime('thoi_gian_nhan');
            $table->dateTime('deadline');
            $table->integer('tinh_trang')->default(0)->comment("0: Chưa hoàn thành; 1: Đã hoàn thành;");
            $table->text('noi_dung')->nullable();
            // $table->integer("so_lan_lap")->nullable();
            // $table->integer("so_ngay_lap")->nullable();
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
        Schema::dropIfExists('giao_tasks');
    }
};
