<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'author',
            'humanResources',
            'managerHr',
            'managerM',
            'manager1',
            'manager2',
            'subscriber',
        ];

        foreach ($roles as $name) {
            Role::firstOrCreate(['name' => $name]);
        }
    }
}
