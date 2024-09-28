<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\User;
use App\Models\View;
use App\Models\Setting;

class AdminController extends Controller
{

    public function welcome() 
    {
        $settings = Setting::first();
        $uploads = Upload::all();

        return view('welcome', compact('settings', 'uploads'));
    }


    public function dashboard()
    {
        // Retrieve statistics
        $totalUploads = Upload::count();
        $newUsers = User::where('created_at', '>=', now()->subMonth())->count();
        $totalViews = View::sum('views');

        // Example chart data - replace with actual data if needed
        $chartLabels = ['January', 'February', 'March', 'April', 'May'];
        $chartData = [10, 30, 50, 70, 100];

        return view('admin.dashboard', compact('totalUploads', 'newUsers', 'totalViews', 'chartLabels', 'chartData'));

    }

    public function manageUploads()
    {
        $uploads = Upload::all(); // Fetch all uploads

        return view('uploads.index', compact('uploads'));
    }



    public function settings()
    {
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

        $settings = Setting::first();

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

        $settings->update([
            'site_name' => $request->input('site_name'),
            'site_description' => $request->input('site_description'),
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}