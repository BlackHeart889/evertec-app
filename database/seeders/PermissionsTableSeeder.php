<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'administrador']);
        $cliente = Role::create(['name' => 'cliente']);
        

        Permission::create(['name' => 'listar pedidos']);
        Permission::create(['name' => 'comprar articulos']);

        $admin->syncPermissions([
            'listar pedidos',
        ]);
        $cliente->syncPermissions([
            'comprar articulos',
        ]);
    }
}
