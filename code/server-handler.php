<?php

/**
 * Server handler
 * Wraps main.php. Except BASE_PATH and FRAMEWORK_PATH to be set by composer's autoload of
 * framework.
 */

// Serve always hosts from the root
define('BASE_URL', '');
define('BASE_PATH', getcwd());

// Include a bootstrap file (e.g. if you need extra settings to get a module started)
if (getenv('SERVE_BOOTSTRAP_FILE')) {
    require_once getenv('SERVE_BOOTSTRAP_FILE');
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== "/" && file_exists(BASE_PATH . $uri) && !is_dir(BASE_PATH . $uri)) {
    return false;
}

$_GET["url"] = $uri;
$_REQUEST["url"] = $uri;


$paths = [
    '/index.php',
    '/vendor/silversstripe/framework/main.php',
    '/framework/main.php',
];
foreach ($paths as $path) {
    if (file_exists(BASE_PATH . $path)) {
        require_once BASE_PATH . $path;
        break;
    }
}
