<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $siswa = [
        //     'fullname' => 'Siswa',
        //     'email' => 'siswa@mail.com',
        //     'username' => 'siswa',
        //     'password' => Hash::make('password')
        // ];

        // $userSiswa = User::create($siswa);
        // $userSiswa->attachRole('siswa');


        // $admin = [
        //     'fullname' => 'Administrator',
        //     'username' => 'admin',
        //     'email' => 'admin@mail.com',
        //     'password' => Hash::make('password')
        // ];

        // $userAdmin = User::create($admin);
        // $userAdmin->attachRole('admin');

        $guru = [
            'fullname' => 'Guru',
            'username' => 'Guru',
            'email' => 'guru@mail.com',
            'password' => Hash::make('password')
        ];

        $userGuru = User::create($guru);
        $userGuru->attachRole('guru');

    }
}
