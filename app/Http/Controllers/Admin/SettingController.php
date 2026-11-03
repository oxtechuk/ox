<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'branding');
        $settings = SiteSetting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings', 'activeTab'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'active_tab']);

        // Handle File Uploads (Logos, Favicon, Audio, Services Cards, etc.)
        $fileKeys = [
            'site_logo_main',
            'site_logo_dark',
            'site_logo_footer',
            'site_favicon',
            'seo_og_image',
            'bg_audio_file',
            'service_card_img_1',
            'service_card_img_2',
            'service_card_img_3',
            'service_card_img_4',
        ];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                if ($fileKey === 'bg_audio_file') {
                    $folder = 'uploads/audio';
                    $group = 'audio';
                } elseif (str_starts_with($fileKey, 'service_card_img_')) {
                    $folder = 'uploads/services';
                    $group = 'services';
                } else {
                    $folder = 'uploads/branding';
                    $group = 'branding';
                }
                $path = $file->store($folder, 'public');

                // Fail-safe: Ensure directory and file are mirrored directly into public/storage
                try {
                    $publicUploadsDir = public_path('storage/'.$folder);
                    if (! file_exists($publicUploadsDir)) {
                        @mkdir($publicUploadsDir, 0755, true);
                    }
                    $sourcePath = storage_path('app/public/'.$path);
                    $destPath = public_path('storage/'.$path);
                    if (file_exists($sourcePath) && ! file_exists($destPath)) {
                        @copy($sourcePath, $destPath);
                    }
                } catch (\Throwable $e) {
                    // Ignore if environment filesystem is read-only or already symlinked
                }

                SiteSetting::set($fileKey, '/storage/'.$path, $group, 'file');
                unset($data[$fileKey]);
            }
        }

        // Handle File Deletion if requested
        if ($request->boolean('delete_bg_audio_file')) {
            SiteSetting::set('bg_audio_file', '', 'audio', 'file');
            unset($data['delete_bg_audio_file']);
        }

        foreach ([1, 2, 3, 4] as $cardIndex) {
            $delKey = 'delete_service_card_img_'.$cardIndex;
            if ($request->boolean($delKey)) {
                SiteSetting::set('service_card_img_'.$cardIndex, '', 'services', 'file');
                unset($data[$delKey]);
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
            } elseif (str_starts_with($key, 'paypal_')) {
                $group = 'paypal';
            } elseif (str_starts_with($key, 'recaptcha_')) {
                $group = 'recaptcha';
            } elseif (str_starts_with($key, 'bg_audio_') || str_starts_with($key, 'audio_')) {
                $group = 'audio';
            } elseif (str_starts_with($key, 'service_card_')) {
                $group = 'services';
            }

            SiteSetting::set($key, is_array($value) ? json_encode($value) : $value, $group);
        }

        return redirect()->route('admin.settings.index', ['tab' => $activeTab])
            ->with('success', 'تم حفظ وتحديث الإعدادات بنجاح!');
    }
}
