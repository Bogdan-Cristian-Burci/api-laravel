<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use Illuminate\Database\Seeder;

class TrainingTypeSeeder extends Seeder
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
                'name'=>'Pregatire profesionala initiala',
                'code'=>'PPI'
            ],
            [
                'name'=>'Pregatire profesionala continua',
                'code'=>'PPC'
            ],
            [
                'name'=>'Definitivat',
                'code'=>'DEF'
            ],
        ];

        foreach ($availableTrainingTypes as $trainingType){

            TrainingType::create([
                'name'=>$trainingType['name'],
                'code'=>$trainingType['code']
            ]);
        }
    }
}
