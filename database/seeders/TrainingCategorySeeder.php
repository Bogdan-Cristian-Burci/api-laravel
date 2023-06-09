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
                'code'=>'X'
            ],
            [
                'name'=>'Conducatori/Conducatori executivi',
                'code'=>'CO CE'
            ],
            [
                'name'=>'Conducatori executivi',
                'code'=>'CE'
            ],
        ];

        foreach ($availableTrainingTypes as $trainingType){

            TrainingCategory::create([
                'name'=>$trainingType['name'],
                'code'=>$trainingType['code']
            ]);
        }
    }
}
