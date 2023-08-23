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
                'code'=>'PPI',
                'price'=>1
            ],
            [
                'name'=>'Pregatire profesionala continua',
                'code'=>'PPC',
                'price'=>1
            ],
            [
                'name'=>'Definitivat',
                'code'=>'DEF',
                'price'=>1
            ],
        ];

        foreach ($availableTrainingTypes as $trainingType){

            TrainingType::create([
                'name'=>$trainingType['name'],
                'code'=>$trainingType['code'],
                'price'=>$trainingType['price']
            ]);
        }
    }
}
