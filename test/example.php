<?php

// See test.php for full documentation.
// This example is similar to test.php but with less documentation.
require_once '../src/Cache.php';

$key = '/users/example';

// Settings
$dir = __DIR__ . '/cache';
$seconds = 2;
$odds = 4;

// New Cache object
$cache = new \cache\src\Cache($dir,$seconds,$odds);

// Check for cached version of key request
$cached = $cache->ReadCache($key);
if ($cached) {
    $content = 'Cached' . $cached;
}

// Write cache is none exists.
else {
    $content = " Content.";
    $cache->WriteCache($key,$content);
    $content = 'Fetched' . $content;
}

echo $content;
