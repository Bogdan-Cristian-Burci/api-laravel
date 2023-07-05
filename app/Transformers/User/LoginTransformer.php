<?php

namespace App\Transformers\User;

use App\Models\User;
use App\Transformers\Quiz\QuizSummaryTransformer;
use App\Transformers\Quiz\QuizTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class LoginTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [

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
        return [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'id' =>$user->id
        ];
    }

    public function includeSummary(User $user): Collection
    {

        $quizzes = $user->quizzes;

        return $this->collection($quizzes, new QuizSummaryTransformer());
    }
}
