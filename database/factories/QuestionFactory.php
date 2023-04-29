<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'chapter_id' => Chapter::factory(),
        ];
    }
}
