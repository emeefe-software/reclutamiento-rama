<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class InsertDefaultRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insert([
            'name'=>'admin',
            'display_name'=>'Administrador',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'password'=>bcrypt('adminroot'),
            'first_name'=>'Javier',
            'last_name'=>'León',
            'email'=>'javierleon@hecco.mx',
            'pin'=>null,
            'phone'=>null,
            'contact_name'=>null,
            'contact_phone'=>null,
            'address'=>null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user = User::where('email','javierleon@hecco.mx')->first();

        try {
            $user->attachRole('admin');
        } catch (\Throwable $th) {
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
