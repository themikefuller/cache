<?php

// test.php and example.php are for testing purposes and explanation.
// This is a barebones example with minimal configuration
// Note: The output for this example is always "Content".
// In real-world use, you don't want to indicate that it is cached.
// Obviously, this does not actually "Fetch" data from anywhere if it isn't cached.

// Require Cached.php
require_once '../src/Cache.php';

// $key - The Unique Key / Request / String
$key = '/users/example';

// $dir - The path to the save cache files
$dir = __DIR__ . '/cache';

// $seconds - The number of seconds to cache a key's content
$seconds = 2;

// $odds - The odds that Garbage Collection will actually run.
$odds = 4;

// New Cache object
$cache = new \cache\src\Cache($dir,$seconds,$odds);

// Read Cache and use existing
$cached = $cache->ReadCache($key);
if ($cached) {
    $content = $cached;
}

// If no cache exists, Fetch the content and then write it to cache.
else {
    // Go Fetch Content
    // This is where you fetch your content if no cache was available.
    // Example: Connect to database, run the query, return results, organize, format, etc...
    // Replace this line with your entire program :)
    $content = "Content";

    // Write content to cache
    $cache->WriteCache($key,$content);
}

echo $content;
