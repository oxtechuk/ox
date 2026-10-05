<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\ProductLandingPage;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML Sitemap for search engine indexation.
     */
    public function sitemap(): Response
    {
        $baseUrl = url('/');
        $locales = ['ar', 'en', 'fr'];

        $projects = Project::select('slug', 'updated_at')->get();
        $products = DigitalProduct::where('status', 'active')->select('slug', 'updated_at')->get();
        $landingPages = ProductLandingPage::where('is_published', true)->select('slug', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        // 1. Static Key Pages with Multilingual Alternates
        $staticPages = [
            ['url' => $baseUrl, 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toAtomString()],
            ['url' => route('projects.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
            ['url' => route('store.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toAtomString()],
        ];

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars($page['url'], ENT_XML1, 'UTF-8').'</loc>';
            $xml .= '<lastmod>'.$page['lastmod'].'</lastmod>';
            $xml .= '<changefreq>'.$page['changefreq'].'</changefreq>';
            $xml .= '<priority>'.$page['priority'].'</priority>';

            foreach ($locales as $loc) {
                $xml .= '<xhtml:link rel="alternate" hreflang="'.$loc.'" href="'.htmlspecialchars($page['url'].'?lang='.$loc, ENT_XML1, 'UTF-8').'"/>';
            }
            $xml .= '</url>';
        }

        // 2. Portfolio Case Studies
        foreach ($projects as $project) {
            $projectUrl = route('projects.show', $project->slug);
            $lastMod = $project->updated_at ? $project->updated_at->toAtomString() : now()->toAtomString();

            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars($projectUrl, ENT_XML1, 'UTF-8').'</loc>';
            $xml .= '<lastmod>'.$lastMod.'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.85</priority>';

            foreach ($locales as $loc) {
                $xml .= '<xhtml:link rel="alternate" hreflang="'.$loc.'" href="'.htmlspecialchars($projectUrl.'?lang='.$loc, ENT_XML1, 'UTF-8').'"/>';
            }
            $xml .= '</url>';
        }

        // 3. Digital Products Catalog
        foreach ($products as $product) {
            $productUrl = route('store.product', $product->slug);
            $lastMod = $product->updated_at ? $product->updated_at->toAtomString() : now()->toAtomString();

            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars($productUrl, ENT_XML1, 'UTF-8').'</loc>';
            $xml .= '<lastmod>'.$lastMod.'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.80</priority>';
            $xml .= '</url>';
        }

        // 4. Sales Landing Pages
        foreach ($landingPages as $lp) {
            $lpUrl = route('store.landing', $lp->slug);
            $lastMod = $lp->updated_at ? $lp->updated_at->toAtomString() : now()->toAtomString();

            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars($lpUrl, ENT_XML1, 'UTF-8').'</loc>';
            $xml .= '<lastmod>'.$lastMod.'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.75</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'text/xml; charset=utf-8');
    }

    /**
     * Generate dynamic robots.txt file with protected route disallows.
     */
    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /admin/login\n";
        $content .= "Disallow: /account/\n";
        $content .= "Disallow: /checkout/\n";
        $content .= "Disallow: /downloads/\n\n";
        $content .= "Sitemap: {$sitemapUrl}\n";

        return response($content, 200)->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Handle safe multi-language locale switching.
     */
    public function switchLanguage(Request $request, string $locale): RedirectResponse
    {
        if (in_array($locale, ['ar', 'en', 'fr'], true)) {
            session(['locale' => $locale]);
            cookie()->queue('locale', $locale, 60 * 24 * 365);
            app()->setLocale($locale);
        }

        $referer = $request->header('referer');
        if ($referer) {
            $parsed = parse_url($referer);
            if (! empty($parsed['query'])) {
                parse_str($parsed['query'], $queryParams);
                unset($queryParams['lang']);
                $newQuery = http_build_query($queryParams);
                $cleanUrl = ($parsed['scheme'] ?? 'http').'://'.($parsed['host'] ?? '').($parsed['path'] ?? '').($newQuery ? '?'.$newQuery : '');

                return redirect($cleanUrl);
            }

            return redirect($referer);
        }

        return redirect()->route('home');
    }
}
