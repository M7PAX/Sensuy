<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:1048576', // 1GB
        ]);

        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $mimeType = $uploadedFile->getClientMimeType();
        $type = explode('/', $mimeType)[0];
        $path = $uploadedFile->store("uploads/{$type}", 'public');

        $file = File::create([
            'post_id' => $request->post_id,
            'name' => $originalName,
            'path' => $path,
            'mime_type' => $mimeType,
        ]);

        return response();
    }

    public function download(File $file)
    {
        return Storage::download($file->path, $file->name);
    }
}
