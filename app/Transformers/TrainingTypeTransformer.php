<?php

namespace App\Transformers;

use App\Models\TrainingType;
use League\Fractal\TransformerAbstract;

class TrainingTypeTransformer extends TransformerAbstract
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
    public function transform(TrainingType $type): array
    {
        return [
            'id'=>$type->id,
            'name'=>$type->name,
            'price'=>$type->price
        ];
    }
}
