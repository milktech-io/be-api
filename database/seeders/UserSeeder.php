<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ProfileService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(ProfileService $ProfileService, AuthService $AuthService)
    {
        $this->ProfileService = $ProfileService;
        $this->AuthService = $AuthService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //usuario
        $profile = Profile::create([
            'name' => 'Jaenn',
            'lastname' => 'Poumian',
            'email' => 'jpoumian@eonnet.io',
            'mobile' => 3313131313,
            'profession' => 'Freelance',
        ]);

        $Jaenn = User::create([
            'username' => 'jpoumian',
            'email' => 'jpoumian@eonnet.io',
            'password' => bcrypt('root1234'),
            'profile_id' => $profile->id,
        ])->fresh();

        $Jaenn->assignRole('usuario');

        $profile = Profile::create([
            'name' => 'luis',
            'lastname' => 'Ibarra',
            'email' => 'libarra@eonnet.io',
            'mobile' => 3313131313,
            'profession' => 'Freelance',
        ]);

        $user = User::create([
            'username' => 'Luisibarra',
            'email' => 'libarra@eonnet.io',
            'password' => bcrypt('root1234'),
            'profile_id' => $profile->id,
            'sponsor_id' => $Jaenn->id,

        ]);

        $user->assignRole('usuario');

        $profile = Profile::create([
            'name' => 'administracion',
            'lastname' => 'administracion',
            'email' => 'administracion@eonnet.io',
            'mobile' => 3313131313,
            'profession' => 'Freelance',
        ]);

        $administracion = User::create([
            'username' => 'administracion',
            'email' => 'administracion@eonnet.io',
            'password' => bcrypt('root1234'),
            'profile_id' => $profile->id,
        ])->fresh();

        $administracion->assignRole('administracion');
        //admin

        $profile = Profile::create([
            'name' => 'administracion2',
            'lastname' => 'administracion2',
            'email' => 'administracio2n@eonnet.io',
            'mobile' => 3313131313,
            'profession' => 'Freelance',
        ]);

        $administracion = User::create([
            'username' => 'administracion2',
            'email' => 'administracion2@eonnet.io',
            'password' => bcrypt('root1234'),
            'profile_id' => $profile->id,
        ])->fresh();

        $administracion->assignRole('administracion');
        //admin

        //soporte

        $profile = Profile::create([
            'name' => 'soporte',
            'lastname' => 'soporte',
            'email' => 'soporte@eonnet.io',
            'mobile' => 3313131313,
            'profession' => 'Freelance',
        ]);

        $soporte = User::create([
            'username' => 'soporte',
            'email' => 'soporte@eonnet.io',
            'password' => bcrypt('root1234'),
            'profile_id' => $profile->id,
        ])->fresh();

        $soporte->assignRole('soporte');
        //admin
    }
}
