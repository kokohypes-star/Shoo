<?php
/**
 * Shoobu Theme Preview Server
 * 
 * Standalone PHP server that simulates WordPress environment
 * to preview the Shoobu theme
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/i', $request_uri)) {
    return false;
}

require_once __DIR__ . '/wp-bootstrap.php';

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

include __DIR__ . '/index.php';
