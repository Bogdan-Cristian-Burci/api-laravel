<?php

namespace App\Transformers;

use App\Models\Training;
use App\Models\UserTraining;
use League\Fractal\TransformerAbstract;

class SingleUserTrainingTransformer extends TransformerAbstract
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
    public function transform(UserTraining $training): array
    {
        $trn = fractal(Training::find($training->training_id),new SingleTrainingTransformer())->toArray();
        return [
            'id'=>$training->id,
            'active'=>$training->active,
            'expire_at'=>$training->expire_at,
            'demo'=>$training->demo_available,
             ...$trn
        ];
    }
}
