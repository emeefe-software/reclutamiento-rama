<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHourUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_user', function (Blueprint $table) {
            $table->integer('hour_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('interview_id')->unsigned()->nullable();
            $table->primary(['hour_id','user_id']);
        });

        Schema::table('hour_user', function (Blueprint $table) {
            $table->foreign('hour_id')->references('id')->on('hours')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('interview_id')->references('id')->on('interviews')->onUpdate('CASCADE')->onDelete('SET NULL');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hour_user',function(Blueprint $table){
            $table->dropForeign('hour_id');
            $table->dropForeign('user_id');
        });
    }
}
