<?php

// Require Cache.php
require_once '../src/Cache.php';

// $key - Use a unique string or specific request
// Examples:
//  URI:           $key = '/users/mike';
//  URI + header:  $key = 'Bearer: aba8b8af3c' . '/posts?id=10';
//  Unique String: $key = json_encode($cacheable_request);

// In this example, the key is the simple request of '/users/example';
$key = '/users/example';

// $dir - File path where cache files will be stored
// Permission to write to this path is required.
// It is highly recommended that you use absolute paths.
// Trailing slashes are removed and then one is added back in (FYI).
// A directory called cache/ will be created in the working directory if not passed
$dir = __DIR__ . '/cache';

// $seconds - The number of seconds in the future to cache a specific key.
// Every second creates an additional, identical file.
// 1 key for 2 seconds is 2 identical files.
// 10 keys for 10 seconds is 100 files, etc..
// New cache files are only created if the current file is expired or does not exist.
// The default is 2
$seconds = 2;

// Load Cache
$cache = new \cache\src\Cache($dir,$seconds);

// Read Cache
$cached = $cache->ReadCache($key);
if ($cached) {

    // Key is cached. $content is set to the cached contents of the file
    // The word CACHED was added here only as an example. Don't do that.
    // Content can vary in type and style.
    $content = 'CACHED - ' . $cached;

} else {

    // If cache does not exist, fetch content and write to cache
    // This just sets the $content variable, but is emulating the task of getting the content.
    // This would be getting the content from the database, organizing it, formatting it, outputing it.
    $content = "Fetched content.";

    // Since there was no cache, we can now create one for this key (request)
    // A cached file will be created for each second in the future.
    // 2 seconds creates two cached files for this key. The default is 2
    // The content that was fetched is passed as the second parameter.
    // NOT ALL RESOURCES OR VALUES CAN OR SHOULD BE CACHED. It depends on your code.
    $cache->WriteCache($key,$content);

}

// Echo the content
echo $content;
