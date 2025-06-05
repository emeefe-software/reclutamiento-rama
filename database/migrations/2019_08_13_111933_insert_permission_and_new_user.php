<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class InsertPermissionAndNewUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = new Permission();
        $permission->name = 'manage_food_payments';
        $permission->display_name = 'Manage food payments';
        $permission->description = 'Puede indicar los pagos que ya se han realizado por parte de los usuarios';
        $permission->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'manage_food_payments')->first()->delete();
    }
}
