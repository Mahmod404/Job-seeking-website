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
        Schema::create('applied_jops', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['accepted', 'rejected', 'pending'])->default('pending'); //done
            $table->foreignId('user_id');
            $table->foreignId('job_id');
            $table->bigInteger('employer_id', false, true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('job_id')->references('id')->on('jobs');
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
        Schema::dropIfExists('applied_jops');
    }
};