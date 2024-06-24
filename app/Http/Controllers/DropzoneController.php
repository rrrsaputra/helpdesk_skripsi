<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropzoneController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            return $path;
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    public function remove(Request $request)
    {
        $fileName = $request->get('fileName');
        $filePath = 'public/uploads/' . $fileName;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return response()->json(['message' => 'File removed successfully'], 200);
        }

        return response()->json(['message' => 'File not found'], 404);
    }
}