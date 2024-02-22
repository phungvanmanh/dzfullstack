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
        Schema::create('khoa_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khoa_hoc')->index();
            $table->longText('mo_ta_khoa')->nullable();
            $table->integer('is_open')->default(1)->index();
            $table->integer('so_buoi_trong_thang')->default(12)->index();
            $table->integer('hoc_phi_theo_thang')->default(2500000)->index();
            $table->integer('so_thang_hoc')->comment('Thường là 3 tháng')->default(3)->index();
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
        Schema::dropIfExists('khoa_hocs');
    }
};
