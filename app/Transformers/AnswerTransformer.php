<?php

namespace App\Transformers;

use App\Models\Answer;
use League\Fractal\TransformerAbstract;

class AnswerTransformer extends TransformerAbstract
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
     * @param Answer $answer
     * @return array
     */
    public function transform(Answer $answer): array
    {
        return [
            'id'=>$answer->id,
            'name'=>$answer->name,
            'description'=>$answer->description,
            'is_correct'=>(boolean)$answer->correct
        ];
    }
}
