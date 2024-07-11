<?php

namespace Database\Seeders;

use App\Base\Constants\Auth\Permission as PermissionSlug;
use App\Base\Constants\Auth\Role as RoleSlug;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use Illuminate\Database\Seeder;
use DB;
// dd(PermissionSlug::ADD_SPORTS);
class RolesAndPermissionsSeeder extends Seeder
{
    /**
      * List of all the permissions to be created.
      *
      * @var array
      */

    protected $permissions = [

//Dashboard and ConfMESS_MANAGERurations
       PermissionSlug::ACCESS_DASHBOARD => [
            'name' => 'Access-Dashboard',
            'description' => 'Access Dashboard',
            'main_menu' => 'dashboard',
            'sub_menu' => null,
            'sort' => 1,
            'main_link' => 'dashboard',
            'icon' => 'fa fa-tachometer'
        ],
        PermissionSlug::ADD_ROOM => [
            'name' => 'add-Room-booking',
            'description' => 'add-Room-booking',
            'main_menu'=>'Bookings',
            'sub_menu'=>'roles',
            'sub_link'=>'roles',
        ],
        PermissionSlug::ADD_PARTY => [
            'name' => 'add-party/lawn',
            'description' => 'Add Aarty/Lawn',
            'main_menu'=>'Bookings',
            'sub_menu'=>'roles',
            'sub_link'=>'roles',
            ],
            PermissionSlug::ADD_SPORT => [
                'name' => 'add-sports',
                'description' => 'Add Sports',
                'main_menu' => 'Bookings',
                'sub_menu' => null,
                'sort' => 12,
                'icon' => 'fa fa-cogs'
            ],
            PermissionSlug::ROOM_BOOKING_MANAGEMENT => [
                'name' => 'room-booking-management',
                'description' => 'room-booking-management',
                'main_menu' => 'Bookings',
                'sub_menu' => null,
                'sort' => 12,
                'icon' => 'fa fa-cogs'
            ],  
        PermissionSlug::ROOM_AVAILABILITY => [
            'name' => 'room-availability-settings',
            'description' => 'Room-Availability',
            'main_menu' => 'Availability',
            'sub_menu' => null,
            'sort' => 12,
            'icon' => 'fa fa-cogs'
        ],
        
];

    /**
     * List of all the roles to be created along with their permissions.
     *
     * @var array
     */
    protected $roles = [
        RoleSlug::SUPER_ADMIN => [
            'name' => 'Super Admin',
            'description' => 'Admin group with unrestricted access',
            'all' => true,
        ],
        RoleSlug::USER => [
            'name' => 'User',
            'description' => 'IAS Officers',
            'permissions' => []
        ],

        RoleSlug::MESS_MANAGER=>[
            'name' => 'Mess Manager',
            'description' => 'Mess Manager',
            'permissions' => [],
        ],
        // RoleSlug::DSP=>[
        //     'name' => 'DSP SJ&HR',
        //     'description' => 'DSP Human RMESS_MANAGERht committee',
        //     'permissions' => [],
        // ],


    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            foreach ($this->permissions as $permissionSlug => $attributes) {
                // Create permission if it doesn't exist
                Permission::firstOrCreate(['slug' => $permissionSlug], $attributes);
            }

            foreach ($this->roles as $roleSlug => $role) {
                // Create role if it doesn't exist
                $createdRole = Role::firstOrCreate(
                    ['slug' => $roleSlug],
                    array_merge(array_except($role, ['permissions']), ['locked' => true])
                );

                // Sync permissions
                if (isset($role['permissions'])) {
                    $rolePermissions = $role['permissions'];
                    $rolePermissionIds = Permission::whereIn('slug', $rolePermissions)->pluck('id');
                    $createdRole->permissions()->sync($rolePermissionIds);
                }
            }

            /**
             * Delete all unused permissions
             */
            $existingPermissions = Permission::pluck('slug')->toArray();

            $newPermissions = array_keys($this->permissions);

            $permissionsToDelete = array_diff($existingPermissions, $newPermissions);

            Permission::whereIn('slug', $permissionsToDelete)->delete();
        });
    }
}
