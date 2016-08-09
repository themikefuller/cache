<?php

// Require Cache.php
require_once '../src/Cache.php';




// $key - Use a unique string or specific request
// Examples:
//      URI:           $key = '/users/mike';
//      URI + header:  $key = 'Bearer: aba8b8af3c' . '/posts?id=10';
//      Unique String: $key = json_encode($cacheable_request);
// In this example, the key is the simple request of '/users/example';
$key = '/users/example';




// $dir - File path where cache files will be stored
    // Permission to write to this path is required.
    // It is highly recommended that you use absolute paths.
    // Trailing slashes are removed and then one is added back in (FYI).
    // A directory called cache/ will be created in the working directory if not passed
    // If your script (and the executing user) has access to write to /tmp that is also an option.
    // for example, try this instead of the example below:    $dir = '/tmp';
$dir = __DIR__ . '/cache';




// $seconds - The number of seconds in the future to cache a specific key.
// The default is 3
$seconds = 3;


// PRACTICAL EXAMPLE

// Create Cache Object
$cache = new \cache\src\Cache($dir,$seconds);

// Read Cache
$cached = $cache->ReadCache($key);
if ($cached) {

    // Key is cached. $content is set to the cached contents of the file
    // The preceeding word 'CACHED- ' was added here only for testing. Don't do that in production.
    // Content can vary in type and style.
    $content = 'CACHED - ' . $cached;

} else {

    // If cache does not exist, fetch content and write to cache
    // This just sets the $content variable, but is emulating the task of getting the content.
    // This would be: Getting the content from the database, Organizing it, Formatting it.
    $content = "Fetched content.";

    // Since there was no cache, we can now create one for this key (request)
    // The content that was fetched is passed in as the second parameter.
    // NOT ALL RESOURCES OR VALUES CAN OR SHOULD BE CACHED. It depends on your code.
    $cache->WriteCache($key,$content);

}

// Echo this trainwreck
echo $content;
