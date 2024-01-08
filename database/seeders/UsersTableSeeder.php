<?php
namespace Database\Seeders;
use App\Models\Maintainer;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrPermissions = [
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage role',
            'create role',
            'edit role',
            'delete role',
            'manage property',
            'create property',
            'edit property',
            'delete property',
            'show property',
            'manage unit',
            'create unit',
            'edit unit',
            'delete unit',
            'manage tenant',
            'create tenant',
            'edit tenant',
            'delete tenant',
            'show tenant',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'manage maintainer',
            'create maintainer',
            'edit maintainer',
            'delete maintainer',
            'manage maintenance request',
            'create maintenance request',
            'edit maintenance request',
            'delete maintenance request',
            'show maintenance request',
            'delete invoice type',
            'create invoice payment',
            'delete invoice payment',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'show expense',
            'manage contact',
            'create contact',
            'edit contact',
            'delete contact',
            'manage support',
            'create support',
            'edit support',
            'delete support',
            'reply support',
            'manage note',
            'create note',
            'edit note',
            'delete note',
            'manage types',
            'create types',
            'edit types',
            'delete types',
            'manage account settings',
            'manage password settings',
            'manage general settings',
            'manage company settings',

        ];
        foreach($arrPermissions as $ap)
        {
            Permission::create(['name' => $ap]);
        }


        // Default Super admin
        $superAdmin = User::create(
            [
                'first_name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'super admin',
                'lang' => 'english',
                'profile' => 'avatar.png',
                'parent_id' => 0,
            ]
        );

        // Default admin role
        $adminRole = Role::create(
            [
                'name' => 'owner',
                'parent_id' => $superAdmin->id,
            ]
        );
        // Default admin permissions
        $adminPermissions = [
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage role',
            'create role',
            'edit role',
            'delete role',
            'manage property',
            'create property',
            'edit property',
            'delete property',
            'show property',
            'manage unit',
            'create unit',
            'edit unit',
            'delete unit',
            'manage tenant',
            'create tenant',
            'edit tenant',
            'delete tenant',
            'show tenant',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'delete invoice type',
            'create invoice payment',
            'delete invoice payment',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'show expense',
            'manage maintainer',
            'create maintainer',
            'edit maintainer',
            'delete maintainer',
            'manage maintenance request',
            'create maintenance request',
            'edit maintenance request',
            'delete maintenance request',
            'show maintenance request',
            'manage contact',
            'create contact',
            'edit contact',
            'delete contact',
            'manage support',
            'create support',
            'edit support',
            'delete support',
            'reply support',
            'manage note',
            'create note',
            'edit note',
            'delete note',
            'manage types',
            'create types',
            'edit types',
            'delete types',
            'manage account settings',
            'manage password settings',
            'manage general settings',
            'manage company settings',
        ];
        foreach($adminPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
            $adminRole->givePermissionTo($permission);
        }
        // Default admin
        $admin = User::create(
            [
                'first_name' => 'Owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'admin',
                'lang' => 'english',
                'profile' => 'avatar.png',
                'subscription' => 1,
                'parent_id' => $superAdmin->id,
            ]
        );
        // Default admin role assign
        $admin->assignRole($adminRole);


        // Default admin role
        $managerRole = Role::create(
            [
                'name' => 'manager',
                'parent_id' => $admin->id,
            ]
        );
        // Default admin permissions
        $managerPermissions = [
            'manage user',
            'create user',
            'edit user',
            'delete user',
            'manage role',
            'create role',
            'edit role',
            'delete user',
            'manage property',
            'create property',
            'edit property',
            'delete property',
            'show property',
            'manage unit',
            'create unit',
            'edit unit',
            'delete unit',
            'manage tenant',
            'create tenant',
            'edit tenant',
            'delete tenant',
            'show tenant',
            'manage invoice',
            'create invoice',
            'edit invoice',
            'delete invoice',
            'show invoice',
            'manage expense',
            'create expense',
            'edit expense',
            'delete expense',
            'show expense',
            'manage maintainer',
            'create maintainer',
            'edit maintainer',
            'delete maintainer',
            'manage maintenance request',
            'create maintenance request',
            'edit maintenance request',
            'delete maintenance request',
            'show maintenance request',
            'manage contact',
            'create contact',
            'edit contact',
            'delete contact',
            'manage support',
            'create support',
            'edit support',
            'delete support',
            'reply support',
            'manage note',
            'create note',
            'edit note',
            'delete note',
            'create invoice payment',
            'delete invoice payment',
        ];
        foreach($managerPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
            $managerRole->givePermissionTo($permission);
        }
        // Default admin
        $manager = User::create(
            [
                'first_name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'manager',
                'lang' => 'english',
                'profile' => 'avatar.png',
                'parent_id' => $admin->id,
            ]
        );
        // Default admin role assign
        $manager->assignRole($managerRole);

        // Default Tenant role
        $tenantRole = Role::create(
            [
                'name' => 'tenant',
                'parent_id' => $admin->id,
            ]
        );
        // Default Tenant permissions
        $tenantPermissions = [
            'manage invoice',
            'show invoice',
            'manage contact',
            'create contact',
            'edit contact',
            'delete contact',
            'manage support',
            'create support',
            'edit support',
            'delete support',
            'reply support',
            'manage note',
            'create note',
            'edit note',
            'delete note',
        ];
        foreach($tenantPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
            $tenantRole->givePermissionTo($permission);
        }
        // Default Tenant
        $tenant = User::create(
            [
                'first_name' => 'Tenant',
                'email' => 'tenant@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'tenant',
                'lang' => 'english',
                'profile' => 'avatar.png',
                'parent_id' => $admin->id,
            ]
        );
        $tenantDetail=new Tenant();
        $tenantDetail->user_id=$tenant->id;
        $tenantDetail->save();

        // Default tenant role assign
        $tenant->assignRole($tenantRole);

        // Default Maintainer role
        $maintainerRole = Role::create(
            [
                'name' => 'maintainer',
                'parent_id' => $admin->id,
            ]
        );
        // Default admin permissions
        $maintainerPermissions = [
            'manage maintenance request',
            'show maintenance request',
            'manage contact',
            'create contact',
            'edit contact',
            'delete contact',
            'manage support',
            'create support',
            'edit support',
            'delete support',
            'reply support',
            'manage note',
            'create note',
            'edit note',
            'delete note',
        ];
        foreach($maintainerPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
            $maintainerRole->givePermissionTo($permission);
        }
        // Default admin
        $maintainer = User::create(
            [
                'first_name' => 'Maintainer',
                'email' => 'maintainer@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'maintainer',
                'lang' => 'english',
                'profile' => 'avatar.png',
                'parent_id' => $admin->id,
            ]
        );
        $maintainerDetail=new Maintainer();
        $maintainerDetail->user_id=$maintainer->id;
        $maintainerDetail->save();

        // Default admin role assign
        $maintainer->assignRole($maintainerRole);
    }
}
