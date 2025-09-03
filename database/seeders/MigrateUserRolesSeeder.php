<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class MigrateUserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!empty($user->role)) {
                $role = Role::where('name', $user->role)->first();
                if ($role) {
                    $user->roles()->syncWithoutDetaching([$role->id]);
                }
            }
        }
    }
}
