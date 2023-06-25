<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demo = Quiz::create([
           'user_id' => 1,
            'name'=>'Demo',
            'training_id' => 1,
            'number_of_questions' => 10
        ]);
        $demoQuestionsIds = Question::take(10)->get()->pluck('id')->toArray();
        $demo->questions()->attach($demoQuestionsIds);
    }
}
