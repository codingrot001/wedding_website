<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\Setting; // Import your Setting model
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    // Show the upload form
    public function create()
    {
        return view('upload');
    }

    // Store uploaded files
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,mp4|max:51200', // Maximum 50MB
        ], [
            'file.max' => 'The uploaded file is too large. Please upload a file smaller than 50MB.',
            'file.mimes' => 'Invalid file type. Only images and MP4 videos are allowed.',
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());

            if (strpos($file->getMimeType(), 'image') !== false) {
                // Process image files
                $filePath = 'uploads/' . $fileName;
                Storage::disk('public')->put($filePath, file_get_contents($file));
            } else {
                // Handle video files
                $filePath = $file->storeAs('uploads', $fileName, 'public');
            }

            Upload::create([
                'file_name' => $fileName,
                'file_path' => '/storage/' . $filePath,
                'file_type' => $file->getClientMimeType(),
            ]);

            return redirect()->route('uploads.index')->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error uploading your file. Please try again.');
        }
    }

    // Display uploaded files in the gallery
    public function index()
    {
        $uploads = Upload::orderBy('created_at', 'desc')->get();
        $settings = Setting::first(); // Fetch the first settings record (adjust this based on your needs)

        return view('uploads.index', compact('uploads', 'settings'));
    }

    public function destroy(Upload $upload)
    {
        // Check if the file exists and delete it
        if (Storage::disk('public')->exists($upload->file_path)) {
            Storage::disk('public')->delete($upload->file_path);
        }

        // Delete the record from the database
        $upload->delete();

        return redirect()->route('admin.uploads.index')->with('success', 'Upload deleted successfully.');
    }
}