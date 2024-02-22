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
        Schema::create('lich_supports', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien')->index();
            $table->date('ngay_lam_viec');
            $table->integer('buoi_lam_viec')->comment('1: Sáng, 2: Chiều, 3: Tối, 4: Khuya')->index();
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
        Schema::dropIfExists('lich_supports');
    }
};
