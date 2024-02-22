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
        Schema::create('de_cuongs', function (Blueprint $table) {
            $table->id();
            $table->string('loai_mon_hoc')->nullable();
            $table->string('ten_mon_hoc')->nullable();
            $table->string('ma_mon_hoc')->nullable();
            $table->integer('quy_tac')->nullable();
            $table->text('noi_dung_sgk')->nullable();
            $table->text('id_quy_tac')->nullable();
            $table->text('CLO')->nullable();
            $table->text('CONT')->nullable();
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
        Schema::dropIfExists('de_cuongs');
    }
};
