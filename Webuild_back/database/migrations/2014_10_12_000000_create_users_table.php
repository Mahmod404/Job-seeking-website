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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); //done
            $table->string('email')->unique(); //done
            $table->string('password'); //done
            $table->string('national_id')->nullable(); //done
            $table->string('mobile'); //done
            $table->string("age", 2); //done
            $table->string("address"); //done
            $table->string("image")->nullable(); //done
            $table->string("criminal_record")->nullable(); //done
            $table->enum('criminal_record_status', ['approved', 'rejected', 'pending'])->default('pending'); //done
            $table->enum('type', ['worker', 'employer']); //done
            $table->string("profession")->nullable(); //done
            $table->text("skills")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps(); //done
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};