<?php

namespace Database\Seeders;

use App\Models\LearningModule;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
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
                'title_module' => 'Biologi',
                'des_module' => 'Testing',
                'content' => 'testing',
                'author' => 'taufiq',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title_module' => 'Matematika',
                'des_module' => 'Testing',
                'content' => 'testing',
                'author' => 'taufiq',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        LearningModule::insert($data);

    }
}
