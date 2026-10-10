<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockMaliciousBots
{
    /**
     * Known vulnerability scanning tools and malicious bot signatures.
     *
     * @var list<string>
     */
    protected array $badSignatures = [
        'sqlmap',
        'nikto',
        'masscan',
        'nmap',
        'zgrab',
        'gobuster',
        'dirbuster',
        'wpscan',
        'acunetix',
        'havij',
        'netsparker',
        'mj12bot',
        'dotbot',
        'petalbot',
        'dataforseobot',
        'semrushbot',
    ];

    /**
     * Whitelist of recognized AI search engines and legitimate crawlers.
     * These should NEVER be blocked under any circumstances.
     *
     * @var list<string>
     */
    protected array $allowedAiAndSearchBots = [
        'googlebot',
        'bingbot',
        'gptbot',
        'chatgpt-user',
        'oai-searchbot',
        'perplexitybot',
        'claudebot',
        'anthropic-ai',
        'google-extended',
        'applebot',
        'meta-externalagent',
        'cohere-ai',
        'bytespider',
        'diffbot',
    ];

    /**
     * Common vulnerability probe paths targeted by malicious bots.
     *
     * @var list<string>
     */
    protected array $maliciousPaths = [
        '.env',
        '.git',
        '.aws',
        'wp-login.php',
        'wp-admin',
        'xmlrpc.php',
        'eval-stdin.php',
        'setup.cgi',
        'phpmyadmin',
        'pma',
        'config.json',
        'dump.sql',
        'backup.sql',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        $path = strtolower($request->path());

        // 1. Always prioritize and pass allowed AI search engines and search crawlers
        foreach ($this->allowedAiAndSearchBots as $allowedBot) {
            if (str_contains($userAgent, $allowedBot)) {
                return $next($request);
            }
        }

        // 2. Block malicious vulnerability probe paths immediately
        foreach ($this->maliciousPaths as $badPath) {
            if ($path === $badPath || str_starts_with($path, $badPath) || str_contains($path, '/'.$badPath)) {
                abort(403, 'Access denied.');
            }
        }

        // 3. Block known vulnerability scanning tools by User-Agent
        if (! empty($userAgent)) {
            foreach ($this->badSignatures as $badBot) {
                if (str_contains($userAgent, $badBot)) {
                    abort(403, 'Automated scraper access forbidden.');
                }
            }
        }

        return $next($request);
    }
}
