<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\User;
use App\Models\View;
use App\Models\Setting;

class AdminController extends Controller
{

    public function index()
{
    // Retrieve the settings
    $settings = Setting::first();

    return view('uploads.index', compact('settings'));
}

    public function dashboard()
    {
        $totalUploads = Upload::count();
        $newUsers = User::where('created_at', '>=', now()->subMonth())->count();
        $totalViews = View::sum('views');

        $chartLabels = ['January', 'February', 'March', 'April', 'May']; // Example
        $chartData = [10, 30, 50, 70, 100]; // Example data

        // Fetch settings for background images
        $settings = Setting::first();
        return view('admin.dashboard', compact('totalUploads', 'newUsers', 'totalViews', 'chartLabels', 'chartData', 'settings'));
    }

    public function settings()
    {
        // Fetch settings or create default ones if they don't exist
        $settings = Setting::first();
        if (!$settings) {
            $settings = Setting::create([
                'site_name' => 'My Awesome Wedding Site',
                'site_description' => 'Welcome to our wedding website where you can find all the details about our special day.',
                'background_image_1' => null,
                'background_image_2' => null,
                'background_image_3' => null,
            ]);
        }

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'background_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve existing settings
        $settings = Setting::first();

        // Handle background image uploads
        if ($request->hasFile('background_image_1')) {
            $imagePath1 = $request->file('background_image_1')->store('backgrounds', 'public');
            $settings->background_image_1 = $imagePath1;
        }

        if ($request->hasFile('background_image_2')) {
            $imagePath2 = $request->file('background_image_2')->store('backgrounds', 'public');
            $settings->background_image_2 = $imagePath2;
        }

        if ($request->hasFile('background_image_3')) {
            $imagePath3 = $request->file('background_image_3')->store('backgrounds', 'public');
            $settings->background_image_3 = $imagePath3;
        }

        // Update other settings fields
        $settings->update([
            'site_name' => $request->input('site_name'),
            'site_description' => $request->input('site_description'),
        ]);

        // Save the settings to the database
        $settings->save();

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
}