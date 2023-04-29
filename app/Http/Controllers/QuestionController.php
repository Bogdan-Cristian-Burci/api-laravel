<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachRequest;
use App\Models\Chapter;
use App\Transformers\PaginatorAdapter;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Transformers\QuestionTransformer;

class QuestionController extends ApiController
{

    /**
     * Get all questions
     * @return JsonResponse
     */
    public function index(){

            $paginator = Question::paginate();
            $questions = $paginator->getCollection();
            $data = fractal($questions,new QuestionTransformer())->paginateWith( new PaginatorAdapter($paginator));

            return $this->successResponse($data,'Collection found with success');
    }

    /**
     * Create new question
     * @param QuestionRequest $request
     * @return JsonResponse
     */
    public function store(QuestionRequest $request){

            $question = Question::create([
                'name'=>$request->input('name'),
                'description'=>$request->input('description'),
                ]);

            $data = fractal($question, new QuestionTransformer());

            return $this->successResponse($data,'Question created with success', 201);
    }

    /**
     * Get question by id
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question): JsonResponse
    {
            $data = fractal($question, new QuestionTransformer())->toArray();

            return $this->successResponse($data,'Question found');
    }

    /**
     * Update question data by id
     * @param QuestionRequest $request
     * @param Question $question
     * @return JsonResponse
     */

    public function update(QuestionRequest $request,Question $question): JsonResponse
    {
            $question->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);

            $data = fractal($question, new QuestionTransformer())->toArray();

            return $this->successResponse($data,'Question updated with success');
    }

    /**
     * Delete question by id
     * @param Question $question
     * @return JsonResponse
     */
    public function destroy(Question $question): JsonResponse
    {
            $question->delete();

            return $this->successResponse(null,'Question deleted with success',204);
    }

    /**
     * Attach question to a chapter
     * @param AttachRequest $request
     * @param Question $question
     * @return JsonResponse
     */
    public function attachQuestionToChapter(AttachRequest $request,Question $question){

            $chapter = Chapter::find($request->input('attach_id'));
            $question->chapter()->associate($chapter);
            $question->save();

            return $this->successResponse(null,'Question attached with success');
    }

    /**
     * Detach question from chapter
     * @param Question $question
     * @return JsonResponse
     */
    public function detachQuestionFromChapter(Question $question){

            $question->chapter()->dissociate();
            $question->save();

            return $this->successResponse(null,'Question detached with success');
    }
}
