<?php

namespace Database\Seeders;

use App\Models\LearningMaterial;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id_module' => 1,
                'title_material' => 'Biologi',
                'content' => 'testing',
                'tipe_material' => 'Text',
                'file_material' => 'https://laravel.com/img/logomark.min.svg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_module' => 1,
                'title_material' => 'Biologi',
                'content' => 'testing',
                'tipe_material' => 'Text',
                'file_material' => 'https://laravel.com/img/logomark.min.svg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_module' => 2,
                'title_material' => 'Matematika',
                'content' => 'testing',
                'tipe_material' => 'Text',
                'file_material' => 'https://laravel.com/img/logomark.min.svg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        LearningMaterial::insert($data);
    }
}
