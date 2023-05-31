<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Chapter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection
{
    public function collection(Collection $rows){

        foreach ($rows as $row){

            \Log::info('reading file '.json_encode($row));

            break;
        }
    }
}
