<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $siswa = Role::create([
            'name' => 'siswa',
            'display_name' => 'Siswa', // optional
            'description' => 'Siswa melakukan Pembelajaran', // optional
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'User Administrator', // optional
            'description' => 'Admin Yang Mengatur Module', // optional
        ]);
    }
}
