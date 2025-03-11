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
        $type = explode('/', $uploadedFile->getClientMimeType())[0] ?? 'other';
        $filename = $uploadedFile->getClientOriginalName();

        $path = $uploadedFile->storeAs(
            "public/uploads/{$type}",
            "{$request->post_id}_{$filename}"
        );

        $file = File::create([
            'post_id' => $request->post_id,
            'name' => $filename,
            'mime_type' => $uploadedFile->getClientMimeType(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function download(File $file)
    {
        return Storage::download($file->path, $file->name);
    }
}
