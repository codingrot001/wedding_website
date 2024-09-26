<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUploadController extends Controller
{
    public function index() {
        $uploads = Upload::all();
        return view('admin.uploads.index',  compact('uploads'));
    }

    public function destroy(Upload $upload) {
        Storage::disk('public')->delete($upload->file_path);
        $upload->delete();
        return redirect()->route('admin.uploads.index')->with('success', 'File deleted successfully!');
    }
}