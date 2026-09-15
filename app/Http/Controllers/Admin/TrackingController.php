<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackingPixel;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $pixels = TrackingPixel::all()->keyBy('platform');
        $availablePlatforms = [
            'meta' => 'Meta Pixel (Facebook & Instagram)',
            'snapchat' => 'Snapchat Pixel',
            'tiktok' => 'TikTok Pixel',
            'google_analytics' => 'Google Analytics 4 (GA4)',
            'google_tag_manager' => 'Google Tag Manager (GTM)',
            'custom' => 'Custom Tracking Code (Header / Footer Scripts)',
        ];

        return view('admin.tracking.index', compact('pixels', 'availablePlatforms'));
    }

    public function update(Request $request)
    {
        $payload = $request->input('pixels', []);

        foreach ($payload as $platform => $data) {
            $isActive = !empty($data['is_active']);
            $pixelId = $data['pixel_id'] ?? null;
            $headCode = $data['head_code'] ?? null;
            $bodyCode = $data['body_code'] ?? null;

            TrackingPixel::updateOrCreate(
                ['platform' => $platform],
                [
                    'pixel_id' => $pixelId,
                    'head_code' => $headCode,
                    'body_code' => $bodyCode,
                    'is_active' => $isActive,
                ]
            );
        }

        TrackingPixel::flushCache();

        return redirect()->route('admin.tracking.index')->with('success', 'تم تحديث إعدادات بكسلات التتبع والتحليلات بنجاح!');
    }
}
