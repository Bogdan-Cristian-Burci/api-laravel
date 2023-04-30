<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsesRequest;
use App\Models\Answer;
use App\Models\Responses;
use App\Transformers\ResponseTransformer;
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

        $response = Responses::create([
            'quiz_question_id' => $request->input('quiz_question_id') ,
            'answer_id' => $request->input('answer_id'),
            'duration'=>$request->input('duration'),
            'is_correct' => (bool)$isCorrect
        ]);

        $data = fractal($response, new ResponseTransformer());

        return $this->successResponse($data,'Response saved with success',201);
    }
}
