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
        $totalQuizzes = $user->quizzes->where('name','!=','Demo')->count();
        $totalTrainings = $user->assignTrainings->where('active','=',1)->count();
        $averagePoints = 0;
        $passedQuizzes = 0;
        if($totalQuizzes > 0){
            $averagePoints = $user->quizzes->reduce(function (int $cary, Quiz $quiz){
                    return $cary + $quiz->responses->filter(function(Response $response){
                            return (bool) $response->is_correct === true;
                        })->count();
                },0) / $totalQuizzes;

            $passedQuizzes = $user->quizzes->filter(function(Quiz $quiz){
                return $quiz->responses->filter(function(Response $response){
                    return (bool) $response->is_correct === true;
                })->count() >= 28;
            })->count();
        }


        return [
            "id"=>$user->id,
            "first_name"=>$user->first_name,
            "last_name"=>$user->last_name,
            "email"=>$user->email,
            "phone"=>$user->phone,
            "icon"=>$user->icon_number,
            "totalQuizzes"=>$user->quizzes->count(),
            "passedQuizzes"=>$passedQuizzes,
            "averagePoints"=>$averagePoints,
            "street"=>$user->street,
            "street2"=>$user->street_additional,
            "county"=>json_decode($user->county),
            "city"=>json_decode($user->city),
            "totalTrainings"=>$totalTrainings
        ];
    }
}
