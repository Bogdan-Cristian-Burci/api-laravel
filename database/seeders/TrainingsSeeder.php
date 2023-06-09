<?php

namespace Database\Seeders;

use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingType;
use Illuminate\Database\Seeder;

class TrainingsSeeder extends Seeder
{
    /**
     * Populate all available trainings for each user
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trainingCategories = TrainingCategory::all();
        $trainingTypes = TrainingType::all();

        foreach ($trainingCategories as $category){

            foreach($trainingTypes as $type){
                Training::create([
                    'training_category_id' => $category->id,
                    'training_type_id' => $type->id
                ]);
            }
        }
    }
}
