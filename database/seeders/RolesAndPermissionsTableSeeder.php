<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class RolesAndPermissionsTableSeeder extends Seeder
{
    private $data = [
        'roles' => ['Admin', 'Operador'],
        'permissions' => [
            [
                'name'  => 'crear todos',
                'for'   =>  ['Admin', 'Operador']
            ],
            [
                'name'  => 'ver todos',
                'for'   =>  ['Admin', 'Operador']
            ],
            [
                'name'  => 'ver todo los todos',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'editar todos',
                'for'   =>  ['Admin', 'Operador']
            ],
            [
                'name'  => 'eliminar todos',
                'for'   =>  ['Admin', 'Operador']
            ],

            // Roles
            [
                'name'  => 'crear roles',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'ver roles',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'editar roles',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'eliminar roles',
                'for'   =>  ['Admin']
            ],

            // Permisos
            [
                'name'  => 'crear permisos',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'ver permisos',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'editar permisos',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'eliminar permisos',
                'for'   =>  ['Admin']
            ],

            // Usuarios
            [
                'name'  => 'crear usuarios',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'ver usuarios',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'editar usuarios',
                'for'   =>  ['Admin']
            ],
            [
                'name'  => 'eliminar usuarios',
                'for'   =>  ['Admin']
            ],
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = ['Admin' => [], 'Operador' => []];

        foreach ($this->data['permissions'] as $permission) {
            $permissionModel = Permission::findOrCreate($permission['name']);

            if (in_array('Admin', $permission['for'])) {
                $permissions['Admin'][] = $permissionModel;
            }

            if (in_array('Operador', $permission['for'])) {
                $permissions['Operador'][] = $permissionModel;
            }
        }

        foreach ($this->data['roles'] as $name) {
            $role = Role::findOrCreate($name);

            $role->givePermissionTo($permissions[$name]);
        }
    }
}
