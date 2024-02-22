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
        Schema::create('danh_sach_quyens', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->integer('type')->index()->comment('0: view, 1: edit, 2: update, 3: delete, 4: create, 5: search, 6: Download, 7: send');
            $table->string('group')->index();
            $table->string('group_id')->index()->nullable();
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
        Schema::dropIfExists('danh_sach_quyens');
    }
};
