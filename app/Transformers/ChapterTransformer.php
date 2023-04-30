<?php

namespace App\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use App\Models\Chapter;
use App\Transformers\QuestionTransformer;

class ChapterTransformer extends TransformerAbstract
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
     * @return array
     */
    public function transform(Chapter $chapter)
    {
        return [
            'id'=>$chapter->id,
            'name'=>$chapter->name
        ];
    }

    /**
     * Returns questions for selected chapter if ?include=questions is added to the Api request
     */
    public function includeQuestions(Chapter $chapter): Collection
    {
        $questions = $chapter->questions;

        return $this->collection($questions, new QuestionTransformer);
    }
}
