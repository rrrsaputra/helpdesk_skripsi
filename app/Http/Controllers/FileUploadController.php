<?php

declare(strict_types=1);
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
 
final class FileUploadController extends Controller
{
    public function process(Request $request)
    {
        $userId = auth()->id();
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $path = $file->store('uploads/' . $userId, 'public');

            return response()->json(['path' => $path], 200);
        } else {
            return response()->json(['error' => 'No file uploaded'], 422);
        }
       
    }
public function revert(Request $request)
{

    $path = $request->path;
    if ($path && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
        return response()->json(['message' => 'File deleted successfully'], 200);
    } else {
        return response()->json(['error' => 'File not found','mess'=> $request->input('path')], 404);

    }
}
}