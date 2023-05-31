<?php

namespace App\Transformers\User;

use App\Models\Quiz;
use App\Models\Response;
use League\Fractal\TransformerAbstract;
use App\Models\User;
class UserSummaryTransformer extends TransformerAbstract
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
     * @param User $user
     * @return array
     */
    public function transform(User $user): array
    {
        $totalQuizzes = $user->quizzes->count();
        $averagePoints = 0;

        if($totalQuizzes > 0){
            $averagePoints = $user->quizzes->reduce(function (int $cary, Quiz $quiz){
                    return $cary + $quiz->responses->filter(function(Response $response){
                            return (bool) $response->is_correct === true;
                        })->count();
                },0) / $totalQuizzes;
        }


        return [
            "id"=>$user->id,
            "name"=>$user->name,
            "email"=>$user->email,
            "totalQuizzes"=>$user->quizzes->count(),
            "averagePoints"=>$averagePoints
        ];
    }
}
