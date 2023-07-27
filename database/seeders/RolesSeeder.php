<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'mecanico']);
        Role::create(['name' => 'recepcionista']);
        Role::create(['name' => 'superadmin']);
        
       
        Permission::create(['name' => 'admin.catergorias.index']);
        Permission::create(['name' => 'admin.catergorias.create']);
        Permission::create(['name' => 'admin.catergorias.edit']);
        Permission::create(['name' => 'admin.catergorias.destroy']);
    }
}
