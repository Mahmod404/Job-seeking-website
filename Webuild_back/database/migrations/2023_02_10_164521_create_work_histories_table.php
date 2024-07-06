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
        // Schema::create('work_histories', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title', 50);
        //     $table->text('description');
        //     $table->string('date');
        //     $table->foreignId("user_id"); //forgein key
        //     $table->foreignId("job_id"); //forgein key
        //     $table->foreign('user_id')->references("id")->on("users");
        //     $table->foreign('job_id')->references("id")->on("jobs");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('work_histories');
    }
};