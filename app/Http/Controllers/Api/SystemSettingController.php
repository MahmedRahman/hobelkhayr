<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;

class SystemSettingController extends Controller
{
    public function getTerms()
    {
        try {
            $terms = Cache::get('settings.terms_and_conditions');
            if (!$terms) {
                $terms = SystemSetting::getValue('terms_and_conditions');
                Cache::put('settings.terms_and_conditions', $terms, 3600);
            }

            return response()->json([
                'status' => true,
                'data' => $terms
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving terms',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPrivacyPolicy()
    {
        try {
            $policy = Cache::get('settings.privacy_policy');
            if (!$policy) {
                $policy = SystemSetting::getValue('privacy_policy');
                Cache::put('settings.privacy_policy', $policy, 3600);
            }

            return response()->json([
                'status' => true,
                'data' => $policy
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving privacy policy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAboutUs()
    {
        try {
            $about = Cache::get('settings.about_us');
            if (!$about) {
                $about = SystemSetting::getValue('about_us');
                Cache::put('settings.about_us', $about, 3600);
            }

            return response()->json([
                'status' => true,
                'data' => $about
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving about us',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update()
    {
        try {
            $settings = request()->get('settings', []);
            
            foreach ($settings as $setting) {
                SystemSetting::updateOrCreate(
                    ['key' => $setting['key']],
                    ['value' => $setting['value']]
                );
                Cache::forget('settings.' . $setting['key']);
            }

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
