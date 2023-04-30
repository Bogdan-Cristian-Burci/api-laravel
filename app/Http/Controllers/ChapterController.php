<?php

namespace App\Http\Controllers;

use App\Transformers\PaginatorAdapter;
use App\Transformers\ChapterTransformer;
use App\Http\Requests\CreateChapterRequest;
use App\Models\Chapter;
use Illuminate\Http\JsonResponse;

class ChapterController extends ApiController
{

    /**
     * Get all chapters
     * @return JsonResponse
     */
    public function index(){

            $paginator = Chapter::paginate();
            $questions = $paginator->getCollection();
            $data = fractal($questions,new ChapterTransformer())->paginateWith( new PaginatorAdapter($paginator));

            return $this->successResponse($data,'Collection found with success');
    }

    /**
     * Create a new chapter
     * @param CreateChapterRequest $request
     * @return JsonResponse
     */
    public function store(CreateChapterRequest $request){

            $chapter = Chapter::create(['name'=>$request->input('name')]);

            $data = fractal($chapter, new ChapterTransformer());

            return $this->successResponse($data, 'Chapter created successfully', 201);
    }

    /**
     * Retrieve chapter by id
     * @param Chapter $chapter
     * @return JsonResponse
     */
    public function show(Chapter $chapter){

            $data = fractal($chapter, new ChapterTransformer())->toArray();

            return $this->successResponse($data,'Chapter found successfully ');
    }

    /**
     * Update chapter data
     * @param CreateChapterRequest $request
     * @param Chapter $chapter
     * @return JsonResponse
     */
    public function update(CreateChapterRequest $request, Chapter $chapter){

            $chapter->update([
                'name' => $request->input('name')
            ]);

            $data = fractal($chapter, new ChapterTransformer())->toArray();

            return $this->successResponse($data,'Chapter updated with success');
    }

    /**
     * Delete chapter by id
     * @param Chapter $chapter
     * @return JsonResponse
     */
    public function destroy(Chapter $chapter){

            foreach ($chapter->questions as $question){
                $question->chapter_id = null;
                $question->save();
            }

            $chapter->delete();

            return $this->successResponse(null,'Chapter deleted with success',204);
    }

}
