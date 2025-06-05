<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramCareerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_career', function (Blueprint $table) {
            $table->integer('program_id')->unsigned();
            $table->integer('career_id')->unsigned();
            $table->bigInteger('responsable_id')->unsigned();
            $table->integer('places');
            $table->primary(['program_id','career_id','responsable_id']);
        });

        Schema::table('program_career', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('career_id')->references('id')->on('careers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('responsable_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_career',function(Blueprint $table){
            $table->dropForeign('program_id');
            $table->dropForeign('career_id');
        });
    }
}
