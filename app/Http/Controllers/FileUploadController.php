<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('file')){
            $path=$request->file('file')->store('/');
            return response()->json($path);
        }

        return 'No file selected';
    }
}
