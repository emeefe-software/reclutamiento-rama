<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentToFoodRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_registers', function (Blueprint $table) {
            $table->datetime('payed_at')->nullable()->after('user_id');
            $table->float('payment')->nullable()->after('payed_at');
            $table->datetime('payment_delivered_at')->nullable()->after('payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_registers', function (Blueprint $table) {
            $table->dropColumn('payed_at');
            $table->dropColumn('payment');
            $table->dropColumn('payment_delivered_at');
        });
    }
}
