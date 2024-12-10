<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SystemSettingController extends Controller
{
    public function index()
    {
        // Get all settings and group them
        $settings = SystemSetting::all()->groupBy('group');
        
        // Initialize default values if they don't exist
        $defaultSettings = [
            [
                'key' => 'terms_and_conditions',
                'value' => 'Enter your Terms & Conditions here',
                'type' => 'html',
                'group' => 'legal'
            ],
            [
                'key' => 'privacy_policy',
                'value' => 'Enter your Privacy Policy here',
                'type' => 'html',
                'group' => 'legal'
            ],
            [
                'key' => 'about_us',
                'value' => 'Enter your About Us content here',
                'type' => 'html',
                'group' => 'about'
            ]
        ];

        // Create settings if they don't exist
        foreach ($defaultSettings as $setting) {
            SystemSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Refresh settings after creating defaults
        $settings = SystemSetting::all()->groupBy('group');

        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            if (!$request->has('settings') || !is_array($request->settings)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid settings data'
                ], 400);
            }

            foreach ($request->settings as $setting) {
                if (!isset($setting['key']) || !isset($setting['value'])) {
                    continue;
                }

                SystemSetting::updateOrCreate(
                    ['key' => $setting['key']],
                    [
                        'value' => $setting['value'],
                        'type' => $setting['type'] ?? 'html',
                        'group' => $setting['group'] ?? 'general'
                    ]
                );
            }

            // Clear cache after update
            Cache::tags(['settings'])->flush();

            return response()->json([
                'status' => true,
                'message' => 'Settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
