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
        Schema::table('hoc_viens', function (Blueprint $table) {
            $table->integer('is_cho_lop')->default(1)->comment("1: Đang chờ lớp, 0: Không đang chờ lớp");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hoc_viens', function (Blueprint $table) {
            //
        });
    }
};
