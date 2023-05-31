<?php

namespace App\Transformers\Quiz;

use App\Models\Quiz;
use App\Transformers\QuestionTransformer;
use App\Transformers\Response\ResponseTransformer;
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
        'questions','results'
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

    /**
     * Get all questions for quizz
     * @param Quiz $quiz
     * @return Collection
     */
    public function includeQuestions(Quiz $quiz): Collection
    {
        $questions = $quiz->questions;

        return $this->collection($questions, new QuestionTransformer());
    }

    public function includeResults(Quiz $quiz): Collection
    {
        $savedResponses = $quiz->responses;
        return $this->collection($savedResponses, new ResponseTransformer());
    }
}
