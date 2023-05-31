<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsesRequest;
use App\Models\Answer;
use App\Models\QuizQuestion;
use App\Models\Response;
use App\Transformers\Response\ResponseTransformer;
use Illuminate\Http\JsonResponse;

class ResponsesController extends ApiController
{

    /**
     * Save response for specific quiz
     * @param ResponsesRequest $request
     * @return JsonResponse
     */
    public function store(ResponsesRequest $request)
    {
        $isCorrect=false;
        try{
            $isCorrect = Answer::find($request->input('answer_id'))->correct;
        }catch (\Exception $e){
            \Log::error('Trying to get answer by id '. $e->getMessage());
        }

        $questionId = Answer::find($request->input('answer_id'))->question->id;
        $quizId=$request->input('quiz_question_id');

        $quizQuestionId = QuizQuestion::where('quiz_id',$quizId)->where('question_id',$questionId)->first();
        $response = Response::create([
            'quiz_question_id' => $quizQuestionId->id ,
            'answer_id' => $request->input('answer_id'),
            'duration'=>$request->input('duration'),
            'is_correct' => (bool)$isCorrect
        ]);

        $data = fractal($response, new ResponseTransformer());

        return $this->successResponse($data,'Response saved with success',201);
    }
}
