<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'correct' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'question_id' => Question::factory(),
        ];
    }
}
