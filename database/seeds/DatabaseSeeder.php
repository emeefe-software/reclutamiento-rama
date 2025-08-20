<?php

use App\Career;
use App\Program;
use App\Role;
use App\University;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
        $this->createUniversities();
        $this->createCareers();
        $this->createPrograms();
    }

    private function createUsers(){
        $user = User::create([
            'password' => Hash::make('12345678'),
            'first_name'=> 'Sebastian',
            'last_name'=> 'Kempis',
            'email'=> 'sebastian.kempis@dingdong.mx ',
            'area'=> 'Recursos Humanos'
        ]);
        $user->attachRoles([Role::ROLE_RESPONSABLE]);
    }

    private function createUniversities(){
        University::create([
            'name' => 'BUAP',
            'description' => 'Benemérita Universidad Autónoma de Puebla'
        ]);
    }

    private function createCareers(){
        Career::create([
            'name'=>'Computación',
            'withCV' =>true,
            'withPortfolio'=>false,
        ]);

        Career::create([
            'name'=>'Diseño',
            'withCV' =>true,
            'withPortfolio'=>true,
        ]);
    }

    private function createPrograms(){
        Program::create([
            'folio' => '12345',
            'name' => 'Desarrollo de aplicaciones web PHP',
            'university_id' => University::first()->id,
            'description' => 'Desarrollo de aplicaciones web PHP',
        ]);

        Program::create([
            'folio' => '12345',
            'name' => 'Desarrollo de aplicaciones móviles',
            'university_id' => University::first()->id,
            'description' => 'Desarrollo de aplicaciones móviles',
        ]);
    }
}
