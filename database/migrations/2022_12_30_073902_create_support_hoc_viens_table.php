<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_hoc_viens', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_vien')->index();
            $table->integer('id_lop_hoc')->index();
            $table->integer('id_nhan_vien')->index();
            $table->integer('noi_nhan_support')->index()->comment('0: Từ Group Facebook, 1: Từ Group Zalo, 2: Từ Inbox FB, 3: Từ Inbox Zalo, 4: Học Viên Cũ');
            $table->string('noi_dung_support')->nullable();
            $table->integer('is_dung_teamview');
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
        Schema::dropIfExists('support_hoc_viens');
    }
};
