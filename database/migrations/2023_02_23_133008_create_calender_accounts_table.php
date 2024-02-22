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
        Schema::create('calender_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('id_account');
            $table->integer('id_info');
            $table->string('ma_mon_hoc');
            $table->string('ten_mon_hoc');
            $table->string('ma_lop_hoc');
            $table->string('co_so');
            $table->string('phong');
            $table->string('thoi_gian_bat_dau');
            $table->string('thoi_gian_ket_thuc');
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
        Schema::dropIfExists('calender_accounts');
    }
};
