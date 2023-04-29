<?php

namespace App\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use App\Models\Question;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        'answers'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        'answers'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Question $question
     * @return array
     */
    public function transform(Question $question): array
    {
        return [
            'id'=>$question->id,
            'name'=>$question->name,
            'description'=>$question->description
        ];
    }

    public function includeAnswers(Question $question): Collection
    {

        $answers = $question->answers;

        return $this->collection($answers, new AnswerTransformer());
    }
}
