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
        Schema::create('mail_tools', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('email_khoi_phuc');
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('mailverify')->nullable();
            $table->integer('sex')->nullable();
            $table->string('UserAgent')->nullable();
            $table->string('ChanelYoutube')->nullable();
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
        Schema::dropIfExists('mail_tools');
    }
};
