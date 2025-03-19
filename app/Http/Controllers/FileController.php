<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:1048576', // 1GB
        ]);

        $uploadedFile = $request->file('file');
        $mimeType = $uploadedFile->getClientMimeType();
        $type = explode('/', $mimeType)[0];
        $path = $uploadedFile->store("uploads/{$type}", "public");

        $file = File::create([
            'post_id' => $request->post_id,
            'path' => $path,
            'mime_type' => $mimeType,
        ]);

        return response()->with('success', 'File uploaded successfully.');
    }

    public function download(File $file)
    {
        return Storage::download($file->path);
    }
}
