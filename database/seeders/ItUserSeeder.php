<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class ItUserSeeder extends Seeder
{
    public function run(): void
    {
        // ساخت یا گرفتن کاربر
        $user = User::firstOrCreate(
            ['idCard' => '4282341920'], // کدملی یا هر فیلد یکتای دیگه
            [
                'name' => 'کاربر آی‌ تی',
                'phone_number' => '09120000000',
                'password' => bcrypt('It@123'), // پسورد پیشفرض
            ]
        );

        // گرفتن نقش IT
        $role = Role::where('name', 'it')->first();

        // اتصال نقش به کاربر
        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
