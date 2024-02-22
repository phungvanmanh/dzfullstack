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
        Schema::table('mail_tools', function (Blueprint $table) {
            $table->integer('is_die')->default(1); //1 là còn sống, 0 đã chết
            $table->integer('is_review')->default(0); //0 là chưa rv, 1 là đã rv lên, 2 đã rv không lên
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_tools', function (Blueprint $table) {
            //
        });
    }
};
