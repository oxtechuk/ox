<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SocialSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'social_instagram' => 'https://www.instagram.com/oxtech.uk',
            'social_github' => 'https://github.com/oxtechuk',
            'social_tiktok' => 'https://www.tiktok.com/@oxtech.uk',
            'social_youtube' => 'https://www.youtube.com/@oxtech-uk',
            'social_linkedin' => 'https://www.linkedin.com/company/ox-tech',
            'contact_email_primary' => 'contact@oxtech.uk',
            'contact_phone_primary' => '+20 10 08616682',
            'google_maps_url' => 'https://share.google/82M8ufbu784MYpH3y',
            'office_egypt_phone' => '+20 10 08616682',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
