<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();  // Retrieve the first record from the settings table
        return view('admin.settings.index', compact('settings'));  // Pass settings to the view
    }

    // Update settings
    public function update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'background_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the settings or create new if none exists
        $settings = Setting::firstOrCreate([]);

        // Handle file uploads for the background images
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

        // Update the other settings
        $settings->site_name = $request->site_name;
        $settings->site_description = $request->site_description;
        $settings->save();  // Save the settings

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}