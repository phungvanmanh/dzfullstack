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
        Schema::create('hoc_vien_lop_hocs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_vien')->index();
            $table->integer('id_lop_hoc')->index();
            $table->integer('is_hoc_vien')->comment('0: Đăng Ký, 1: Học Viên, 2: Bỏ Học')->default(0)->index();
            $table->integer('id_nhan_vien_add_facebook')->comment('0: Chưa add, > 0 thì điền')->default(0)->index();
            $table->integer('id_nhan_vien_add_zalo')->comment('0: Chưa add, > 0 thì điền')->default(0)->index();
            $table->integer('is_add_fb')->default(0)->index();
            $table->integer('is_add_zalo')->default(0)->index();

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
        Schema::dropIfExists('hoc_vien_lop_hocs');
    }
};
