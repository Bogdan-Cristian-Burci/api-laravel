<?php

namespace Database\Seeders;

use App\Models\TrainingCategory;
use Illuminate\Database\Seeder;

class TrainingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $availableTrainingTypes = [
            [
                'name'=>'Intermediari in asigurari',
                'code'=>'X',
                'multiplier'=>29
            ],
            [
                'name'=>'Conducatori/Conducatori executivi',
                'code'=>'CO CE',
                'multiplier'=>33
            ],
            [
                'name'=>'Conducatori executivi',
                'code'=>'CE',
                'multiplier'=>37
            ],
        ];

        foreach ($availableTrainingTypes as $trainingType){

            TrainingCategory::create([
                'name'=>$trainingType['name'],
                'code'=>$trainingType['code'],
                'multiplier'=>$trainingType['multiplier']
            ]);
        }
    }
}
