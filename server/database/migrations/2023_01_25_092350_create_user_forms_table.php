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
        Schema::create('user_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->foreign('job_id')->references('job_id')->on('job_posts');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('pdf');
            $table->string('skills');
            $table->integer('experience');
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
        Schema::dropIfExists('user_forms');
    }
};
