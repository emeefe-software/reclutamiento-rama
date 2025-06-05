<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Role;
use App\User;

class InsertPracticingRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = new Role();
        $role->name = 'practicing';
        $role->display_name = 'Practicante';
        $role->description = 'Practicante de RAMA';
        $role->save();

        foreach(User::all() as $user){
            if($user->roles()->count() == 0){
                try {
                    $user->attachRole('practicing');
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
