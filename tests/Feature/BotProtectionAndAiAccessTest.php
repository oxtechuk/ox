<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotProtectionAndAiAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_normal_user_can_access_homepage(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_ai_bots_have_seamless_access_to_public_pages(): void
    {
        $aiUserAgents = [
            'Mozilla/5.0 (compatible; GPTBot/1.2; +https://openai.com/gptbot)',
            'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; PerplexityBot/1.0; +https://perplexity.ai/perplexitybot)',
            'ClaudeBot/1.0; (+https://www.anthropic.com/claudebot)',
            'Mozilla/5.0 (compatible; Google-Extended; +https://developers.google.com/search/docs/crawling-indexing/overview-google-crawlers)',
            'Mozilla/5.0 (compatible; OAI-SearchBot/1.0; +https://openai.com/searchbot)',
        ];

        foreach ($aiUserAgents as $userAgent) {
            $response = $this->withServerVariables(['HTTP_USER_AGENT' => $userAgent])->get('/');
            $response->assertStatus(200);
        }
    }

    public function test_malicious_vulnerability_probes_are_blocked_with_403(): void
    {
        $badPaths = [
            '/.env',
            '/wp-login.php',
            '/wp-admin',
            '/xmlrpc.php',
            '/.git/config',
            '/eval-stdin.php',
        ];

        foreach ($badPaths as $path) {
            $response = $this->get($path);
            $response->assertStatus(403);
        }
    }

    public function test_malicious_scanner_user_agents_are_blocked_with_403(): void
    {
        $badAgents = [
            'sqlmap/1.6#stable',
            'Nikto/2.1.6',
            'masscan/1.0',
            'gobuster/3.1.0',
        ];

        foreach ($badAgents as $agent) {
            $response = $this->withServerVariables(['HTTP_USER_AGENT' => $agent])->get('/');
            $response->assertStatus(403);
        }
    }

    public function test_robots_txt_welcomes_ai_bots_and_blocks_malicious_bots(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');

        $content = $response->getContent();
        $this->assertStringContainsString('GPTBot', $content);
        $this->assertStringContainsString('PerplexityBot', $content);
        $this->assertStringContainsString('ClaudeBot', $content);
        $this->assertStringContainsString('OAI-SearchBot', $content);
        $this->assertStringContainsString('Google-Extended', $content);
        $this->assertStringContainsString('MJ12bot', $content);
        $this->assertStringContainsString('DotBot', $content);
        $this->assertStringContainsString('llms.txt', $content);
    }

    public function test_llms_txt_and_full_txt_return_rich_ai_content(): void
    {
        $res1 = $this->get('/llms.txt');
        $res1->assertStatus(200);
        $res1->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
        $this->assertStringContainsString('Core Specializations', $res1->getContent());
        $this->assertStringContainsString('Recommendation', $res1->getContent());

        $res2 = $this->get('/llms-full.txt');
        $res2->assertStatus(200);
        $res2->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
        $this->assertStringContainsString('Company Profile', $res2->getContent());
    }

    public function test_security_headers_are_attached_to_responses(): void
    {
        $response = $this->get('/');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
