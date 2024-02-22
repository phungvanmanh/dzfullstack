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
        Schema::create('lich_de_cuongs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_mon_hoc');
            $table->string('loai_mon');
            $table->integer('buoi_thu')->nullable();
            $table->integer('so_buoi_de_cuong')->nullable();
            $table->text('tieu_de')->nullable();
            $table->text('noi_dung')->nullable();
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
        Schema::dropIfExists('lich_de_cuongs');
    }
};
