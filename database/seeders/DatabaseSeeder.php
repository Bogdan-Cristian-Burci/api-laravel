<?php

namespace Database\Seeders;

use App\Models\Training;
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

        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            TrainingTypeSeeder::class,
            TrainingCategorySeeder::class,
            TrainingsSeeder::class,
            RealQuestionsSeeder::class,
            QuizDemoSeeder::class
        ]);
    }
}
