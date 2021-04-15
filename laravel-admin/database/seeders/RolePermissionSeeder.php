<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = Permission::all();
        $admin = Role::whereName('admin')->first();
        foreach($permissions as $permission){
            DB::table('role_permission')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id,
            ]);    
        }
       
        $author = Role::whereName('author')->first();
        foreach($permissions as $permission){
            if(!in_array($permission->name, ['edit_roles'])){
                DB::table('role_permission')->insert([
                    'role_id' => $author->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }

        $viewerRoles = ['view_users', 'view_roles', 'view_products', 'view_orders'];
        $viewer = Role::whereName('user')->first();
        foreach($permissions as $permission){
            if(in_array($permission->name, $viewerRoles)){
                DB::table('role_permission')->insert([
                    'role_id' => $viewer->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
       
    }
}
