<?php

use ElBiniou\Rawg\Client;

require __DIR__.'/source/autoload.php';

$client = new Client();

$categories = $client->getCategories();
print_r($categories);
echo "\n================\n";


print_r(
    $client->getPlatforms()
);

echo "\n================\n";


print_r(
    $client->getTags()
);

echo "\n================\n";


print_r(
    $client->getGames()
);


