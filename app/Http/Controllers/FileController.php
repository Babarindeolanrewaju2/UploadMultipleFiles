<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    public function index()
    {
        return view('file');
    }

    public function save(Request $request)
    {
        request()->validate([
            'file' => 'required|mimes:doc,docx,pdf,txt|max:2048',
        ]);

        if ($files = $request->file('file')) {
            $destinationPath = public_path('uploads/files'); // upload path
            $file = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
        }
        $document = new File;
        $document->nameOfFile = $file;
        $document->save();

        return Redirect::to("file")
            ->withSuccess('Great! file has been successfully uploaded.');

    }
}
