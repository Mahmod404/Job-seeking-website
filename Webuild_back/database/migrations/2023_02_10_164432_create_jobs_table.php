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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 80);
            $table->text('description');
            $table->string('category', 50)->nullable();
            $table->float('salary');
            $table->string('location');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('status', ['available', 'unavailable'])->default('available'); //done
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
        Schema::dropIfExists('jobs');
    }
};
