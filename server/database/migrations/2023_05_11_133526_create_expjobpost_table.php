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
        Schema::create('expjobpost', function (Blueprint $table) {
            $table->id('job_id');
            $table->string('title');
            $table->string('description');
            $table->date('due_date')->format('d-m-Y');
            $table->integer('company_id')->unsigned();
            $table->boolean('status')->default(1)->comment("1 for active 0 for expire");
            $table->foreign('company_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('expjobpost');
    }
};
