<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Chapter;
use App\Models\Question;
use Database\Factories\ChapterFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $chapters = Chapter::factory()
            ->has(Question::factory()
                ->has(Answer::factory()->afterMaking(function (Answer $answer){
                    $answer->correct = true;
                })->count(1),'answers')
                ->has(Answer::factory()->afterMaking(function (Answer $answer){
                    $answer->correct = false;
                })->count(2),'answers')
            ->count(10),'questions')
            ->count(3)->create();
    }
}
