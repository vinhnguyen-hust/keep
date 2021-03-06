<?php

use Keep\Entities\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name'         => 'owner',
                'description'  => 'User is the owner of Keep'
            ],
            [
                'name'         => 'admin',
                'description'  => 'User is allowed to manage and edit other users/tasks/assignments/notifications'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
