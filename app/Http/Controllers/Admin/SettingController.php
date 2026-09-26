<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'branding');
        $settings = SiteSetting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings', 'activeTab'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'active_tab']);

        // Handle File Uploads (Logos, Favicon, etc.)
        $fileKeys = ['site_logo_main', 'site_logo_dark', 'site_logo_footer', 'site_favicon', 'seo_og_image'];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filename = $fileKey.'_'.time().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/branding', $filename, 'public');
                SiteSetting::set($fileKey, '/storage/'.$path, 'branding', 'file');
                unset($data[$fileKey]);
            }
        }

        // Determine group by tab or key
        $activeTab = $request->input('active_tab', 'general');

        foreach ($data as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'seo_')) {
                $group = 'seo';
            } elseif (str_starts_with($key, 'contact_') || str_starts_with($key, 'office_')) {
                $group = 'contact';
            } elseif (str_starts_with($key, 'social_')) {
                $group = 'social';
            } elseif (str_starts_with($key, 'footer_')) {
                $group = 'footer';
            } elseif (str_starts_with($key, 'mail_')) {
                $group = 'mail';
            } elseif (str_starts_with($key, 'paysky_')) {
                $group = 'paysky';
            }

            SiteSetting::set($key, is_array($value) ? json_encode($value) : $value, $group);
        }

        return redirect()->route('admin.settings.index', ['tab' => $activeTab])
            ->with('success', 'تم حفظ وتحديث الإعدادات بنجاح!');
    }
}
