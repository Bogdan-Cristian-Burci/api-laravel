<?php

namespace App\Transformers;

use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingType;
use League\Fractal\TransformerAbstract;

class SingleTrainingTransformer extends TransformerAbstract
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
    public function transform(Training $training): array
    {
        return [
            'category'=>fractal(TrainingCategory::find($training->training_category_id), new TrainingCategoryTransformer())->toArray(),
            'type'=>fractal(TrainingType::find($training->training_type_id), new TrainingTypeTransformer())->toArray(),
            'total_price'=>$training->total_price
        ];
    }
}
