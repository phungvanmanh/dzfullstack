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
        Schema::create('thong_ke_key_words', function (Blueprint $table) {
            $table->id();
            $table->date('ngay_thong_ke');
            $table->string('key_word');
            $table->integer('id_keyword');
            $table->integer('so_lan_click');
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
        Schema::dropIfExists('thong_ke_key_words');
    }
};
