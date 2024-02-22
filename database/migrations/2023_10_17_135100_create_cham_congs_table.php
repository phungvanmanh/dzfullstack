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
        Schema::create('cham_congs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nhan_vien');
            $table->longText('ghi_chu')->nullable();
            $table->string('ip_cham_cong');
            $table->integer('trang_thai')->comment("0: Đi Trễ ; 1 : Đi Đúng Giờ");
            $table->integer('ca')->comment("0 : Sáng ; 1 : Chiều ; 2 : Tối");
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
        Schema::dropIfExists('cham_congs');
    }
};
