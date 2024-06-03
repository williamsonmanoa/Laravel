<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // create role admin
        $roleAdmin = Role::where('name','root')->first();
        if( !$roleAdmin){
            $role = Role::create(['name' => 'root']);
            $permissionRoot = Permission::create(['name' => 'root']);
            $role->givePermissionTo($permissionRoot);
        }

        // create role equipe
        $roleEquipe = Role::where('name','admin-equipe')->first();
        if( !$roleEquipe ){
            $role = Role::create(['name' => 'admin-equipe']);
            $permissionEquipe = Permission::create(['name' => 'admin-equipe']);
            $role->givePermissionTo($permissionEquipe);
        }

        //attribute root role
        $userRoot = User::where('email','admin@gmail.com')->first();
        if( $userRoot && !$userRoot->role('root')->count() ){
            $userRoot->assignRole('root');
        }

        //attribute admin-equipe role
        $userEquipe = User::where('email','admmin-equipe@gmail.com')->first();
        if( $userEquipe && !$userEquipe->role('admin-equipe')->count() ){
            $userEquipe->assignRole('admin-equipe');
        }
    }
}
