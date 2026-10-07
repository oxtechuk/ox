<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// die('PATH: ' . Request::capture()->path() . ' | URI: ' . $_SERVER['REQUEST_URI']);
// Wamp/Apache on Windows subfolder & case-insensitivity support:
// 1. URL can be /ox/ while folder on disk is /Ox/
// 2. URL can be /ox/projects (rewritten by root .htaccess) or /ox/public/projects
if (isset($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'])) {
    $parsedUriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';

    // Check if the request was rewritten through root .htaccess (no /public/ in URI)
    if (! preg_match('#/public(/|$)#i', $parsedUriPath) && preg_match('#/public(/index\.php)?$#i', $_SERVER['SCRIPT_NAME'])) {
        $_SERVER['SCRIPT_NAME'] = preg_replace('#/public(/index\.php)?$#i', '/index.php', $_SERVER['SCRIPT_NAME']);
        if (isset($_SERVER['PHP_SELF'])) {
            $_SERVER['PHP_SELF'] = preg_replace('#/public(/index\.php)?$#i', '/index.php', $_SERVER['PHP_SELF']);
        }
    }

    // Match case of SCRIPT_NAME directory prefix to the case of REQUEST_URI
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if ($scriptDir !== '/' && $scriptDir !== '.') {
        $len = strlen($scriptDir);
        if (strncasecmp($parsedUriPath, $scriptDir, $len) === 0) {
            $matchedCase = substr($parsedUriPath, 0, $len);
            $_SERVER['SCRIPT_NAME'] = $matchedCase.substr($_SERVER['SCRIPT_NAME'], $len);
            if (isset($_SERVER['PHP_SELF'])) {
                $_SERVER['PHP_SELF'] = $matchedCase.substr($_SERVER['PHP_SELF'], $len);
            }
        }
    }
}

$app->handleRequest(Request::capture());
