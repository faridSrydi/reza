<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
$user = User::create([
            'name' => 'Saeful Muminin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        $role = Role::find(1);
        $user->assignRole($role);

    }
}
