<?php

namespace App\Transformers;

use App\Models\TrainingCategory;
use League\Fractal\TransformerAbstract;

class TrainingCategoryTransformer extends TransformerAbstract
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
    public function transform(TrainingCategory $trainingCategory): array
    {
        return [
            'id'=>$trainingCategory->id,
            'name'=>$trainingCategory->name,
            'multiplier'=>$trainingCategory->multiplier
        ];
    }
}
