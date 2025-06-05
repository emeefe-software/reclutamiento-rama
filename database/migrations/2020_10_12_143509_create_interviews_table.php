<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status',[
                'scheduled',
                'unrealized',
                'done-checking',
                'done-accepted',
                'done-rejected',
                'done-enrolled'
            ]);
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('career_id');
            $table->string('CV')->nullable();
            $table->string('portfolio')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('interviews', function(Blueprint $table){
            $table->foreign('program_id')->references('id')->on('programs')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('career_id')->references('id')->on('careers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
