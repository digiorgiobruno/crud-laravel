<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
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
        // \App\Models\User::factory(10)->create();
        //creamos usuario Admi
        User::create([
            'name' => "Bruno",
            'surname' => "Di Giorgio",
            'email' => "bdigiorgio.transporte@gmail.com",
            'cuil' => "20365540811",
            'password' => Hash::make("transporte2022"),
        ]); 
        //creamos rol de administrador
        Role::create([
            'role' => "Admin",
        ]);
        //le damos permiso de administrador
        $user = User::find(1);
        $user->roles()->attach(1);
       


    }
}
