<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'users.manage',
            'inventario.view','inventario.create','inventario.edit',
            'preoperacional.view','preoperacional.create',
            'formatos.view','formatos.create',
            'dashboard.view',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $operativo = Role::firstOrCreate(['name' => 'operativo']);

        $admin->syncPermissions($permissions);

        $operativo->syncPermissions([
            'inventario.view',
            'preoperacional.view','preoperacional.create',
            'formatos.view','formatos.create',
            'dashboard.view',
        ]);

        $user = User::firstOrCreate(
            ['email' => 'admin@bomberos.local'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin#12345'),
            ]
        );

        $user->assignRole('admin');
    }
}
