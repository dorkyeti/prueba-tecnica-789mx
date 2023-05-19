<?php

namespace Database\Seeders;

use App\Models\{ToDo, User};
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        $admin = User::create([
            'name'      => 'Persona Administrador',
            'email'     => 'admin@mail.com',
            'password'  => 'password'
        ]);

        $admin->assignRole('admin');

        if (app()->isProduction())
            # Si la app esta en producción no podremos usar los factories asi que mejor lo dejamos hasta aca
            return;

        // Usuarios Operadores
        $users = User::factory(10)
            ->has(ToDo::factory()->count(random_int(5, 10)), 'todos')
            ->create();

        $users->map(function ($user) {
            $user->assignRole('Operador');

            return $user;
        });
    }
}
