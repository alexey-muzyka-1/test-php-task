<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

$keepSymfonyCache = $_SERVER['KEEP_SYMFONY_TEST_CACHE'] ?? $_ENV['KEEP_SYMFONY_TEST_CACHE'] ?? false;
if (!$keepSymfonyCache) {
    $filesystem = new Filesystem();
    $filesystem->remove([__DIR__.'/../var/cache/test']);

    echo "\nTest cache cleared\n";
}
