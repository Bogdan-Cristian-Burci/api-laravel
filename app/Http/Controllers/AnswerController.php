<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\CreateAnswerRequest;
use App\Http\Requests\Answer\UpdateAnswerRequest;
use App\Http\Requests\AttachRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Transformers\AnswerTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;


class AnswerController extends ApiController
{

    /**
     * Create new answer
     * @param CreateAnswerRequest $request
     * @return JsonResponse
     */
    public function store(CreateAnswerRequest $request){

        $answer = Answer::create([
           'name'=>$request->input('name'),
           'description' => $request->input('description'),
           'question_id' => $request->input('question_id')
        ]);

        $data = fractal($answer, new AnswerTransformer());

        return $this->successResponse($data,'Answer created with success',201);
    }

    /**
     * Retrieve answer by id
     * @param Answer $answer
     * @return JsonResponse
     */
    public function show(Answer $answer){

        $data = fractal($answer, new AnswerTransformer());

        return $this->successResponse($data,'Answer found successfully');
    }

    /**
     * Update answer name and description
     * @param UpdateAnswerRequest $request
     * @param Answer $answer
     * @return JsonResponse
     */
    public function update(UpdateAnswerRequest $request, Answer $answer){

        $fieldsToUpdate = [];

        if($request->input('name')) $fieldsToUpdate = Arr::add($fieldsToUpdate,'name',$request->input('name'));
        if($request->input('description')) $fieldsToUpdate = Arr::add($fieldsToUpdate,'description',$request->input('description'));
        if($request->input('question_id')) $fieldsToUpdate = Arr::add($fieldsToUpdate,'question_id',$request->input('question_id'));
        if($request->input('correct')) $fieldsToUpdate = Arr::add($fieldsToUpdate,'correct',$request->input('correct'));


        $answer->update($fieldsToUpdate);

        $data = fractal($answer, new AnswerTransformer());

        return $this->successResponse($data,'Answer updated successfully');
    }

    /**
     * Delete answer
     * @param Answer $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer){

        $answer->delete();

        return $this->successResponse(null,'Answer deleted with success',204);
    }

    /**
     * Attach an answer to a question
     * @param AttachRequest $request
     * @param Answer $answer
     * @return JsonResponse
     */
    public function attachAnswerToQuestion(AttachRequest $request, Answer $answer){

        $question = Question::find($request->input('attach_id'));

        $answer->question()->associate($question);
        $answer->save();

        return $this->successResponse(null,'Answer attached with success');
    }

    /**
     * Detach answer from question
     * @param Answer $answer
     * @return JsonResponse
     */
    public function detachAnswerFromQuestion(Answer $answer){

        $answer->question()->disassociate();
        $answer->save();

        return $this->successResponse(null,'Answer detached with success');
    }
}
