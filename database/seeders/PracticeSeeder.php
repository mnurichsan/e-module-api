<?php

namespace Database\Seeders;

use App\Models\Practice;
use Illuminate\Database\Seeder;

class PracticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answerChoices = [
            'A.Satu',
            'B. Dua',
            'C. Tiga',
            'D. Empat'
        ];

        $data = [
            [
                'id_material' => 1,
                'title' => 'Testing',
                'quiz' => 'testing',
                'answer_choices' => json_encode($answerChoices),
                'correct_answer' => 'A',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_material' => 1,
                'title' => 'Testing',
                'quiz' => 'testing',
                'answer_choices' => json_encode($answerChoices),
                'correct_answer' => 'B',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_material' => 2,
                'title' => 'Testing',
                'quiz' => 'testing',
                'answer_choices' => json_encode($answerChoices),
                'correct_answer' => 'C',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_material' => 3,
                'title' => 'Testing',
                'quiz' => 'testing',
                'answer_choices' => json_encode($answerChoices),
                'correct_answer' => 'D',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];


        Practice::insert($data);

    }
}
