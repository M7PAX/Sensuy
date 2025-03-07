<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);

        $uploadedFile = $request->file('file');

        $file = new File();
        $file->name = $uploadedFile->getClientOriginalName();
        $file->mime_type = $uploadedFile->getClientMimeType();
        $file->post_id = id();
        $file->save();

        $path = $uploadedFile->store('uploads', 'public');
        $size = $uploadedFile->getSize();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function download(File $file)
    {
        return response()->download(storage_path("app/public/{$file->path}"), $file->name);
    }
}
