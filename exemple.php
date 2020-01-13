<?php

use ElBiniou\RawgClient;

require __DIR__.'/RawgClient.php';

$client = new RawgClient();

$categories = $client->getCategories();
print_r($categories);
echo "\n================\n";

print_r(
    $client->getPlatforms()
);

echo "\n================\n";

/*
print_r(
    $client->getTags()
);
*/
