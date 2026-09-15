<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TrackingPixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'pixel_id',
        'is_active',
        'custom_head_script',
        'custom_body_script',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getActivePixels()
    {
        return Cache::rememberForever('active_tracking_pixels', function () {
            return static::where('is_active', true)->get();
        });
    }

    public static function flushCache()
    {
        Cache::forget('active_tracking_pixels');
    }

    public function renderHeadScript(): string
    {
        if (!$this->is_active) {
            return '';
        }

        $id = e($this->pixel_id);

        return match ($this->platform) {
            'google_analytics' => $id ? <<<HTML
<!-- Google Analytics 4 (GA4) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$id}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{$id}');
</script>
HTML : '',

            'google_tag_manager' => $id ? <<<HTML
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{$id}');</script>
HTML : '',

            'meta' => $id ? <<<HTML
<!-- Meta Pixel -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{$id}');
fbq('track', 'PageView');
</script>
HTML : '',

            'snapchat' => $id ? <<<HTML
<!-- Snapchat Pixel -->
<script type='text/javascript'>
(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
r.src=n;var u=t.getElementsByTagName(s)[0];
u.parentNode.insertBefore(r,u);})(window,document,
'https://sc-static.net/scevent.min.js');
snaptr('init', '{$id}');
snaptr('track', 'PAGE_VIEW');
</script>
HTML : '',

            'tiktok' => $id ? <<<HTML
<!-- TikTok Pixel -->
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
  ttq.load('{$id}');
  ttq.page();
}(window, document, 'ttq');
</script>
HTML : '',

            'custom' => $this->custom_head_script ?? '',
            default => '',
        };
    }

    public function renderBodyScript(): string
    {
        if (!$this->is_active) {
            return '';
        }

        $id = e($this->pixel_id);

        return match ($this->platform) {
            'google_tag_manager' => $id ? <<<HTML
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$id}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
HTML : '',

            'meta' => $id ? <<<HTML
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={$id}&ev=PageView&noscript=1"/></noscript>
HTML : '',

            'custom' => $this->custom_body_script ?? '',
            default => '',
        };
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('active_tracking_pixels');
        });

        static::deleted(function () {
            Cache::forget('active_tracking_pixels');
        });
    }
}
