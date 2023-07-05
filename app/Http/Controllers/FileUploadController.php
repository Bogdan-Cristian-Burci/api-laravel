<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $path=$file->storeAs('/',$fileName);
            return response()->json($path);
        }

        return 'No file selected';
    }
}
