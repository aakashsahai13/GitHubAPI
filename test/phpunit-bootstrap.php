<?php

include __DIR__ . '/../autoload.php';

spl_autoload_register(function ($class) {
    if (strpos($class, 'GitHubAPIv3Test\\') === 0) {
        include __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
    }
});