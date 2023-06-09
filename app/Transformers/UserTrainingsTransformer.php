<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTrainingsTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user): array
    {

        $trainings = $user->assignTrainings->map(function($item){
           return fractal($item,new SingleUserTrainingTransformer())->toArray();
        })->groupBy('category.id')->map(function($items){
            $category=$items->first()['category'];
            $children= $items->map(function($item){
                return [
                    "training_id"=>$item['id'],
                    ...$item['type'],
                    "active"=>$item['active'],
                    "expire"=>$item['expire_at']
                ];
            })->values();

            return[
                "id"=>$category['id'],
                "name"=>$category['name'],
                "children"=>$children
            ];
        });

        return [
            ...$trainings
        ];
    }
}
