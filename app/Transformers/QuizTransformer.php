<?php

namespace App\Transformers;

use App\Models\Quiz;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class QuizTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        'questions'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        'questions'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Quiz $quiz
     * @return array
     */
    public function transform(Quiz $quiz): array
    {
        return [
            'id'=>$quiz->id,
            'name'=>$quiz->name
        ];
    }

    public function includeQuestions(Quiz $quiz): Collection
    {

        $questions = $quiz->questions;

        return $this->collection($questions, new QuestionTransformer());
    }
}
