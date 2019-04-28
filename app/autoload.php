<?php
/* Define Application Path */
$ds = DIRECTORY_SEPARATOR;
define('ROOT_PATH', dirname(__DIR__) . $ds);
define('APP_PATH', ROOT_PATH . 'app' . $ds);
define('PUBLIC_PATH', ROOT_PATH . 'public' . $ds);
define('STORAGE_PATH', ROOT_PATH . 'storage' . $ds);

/* autoload vendor */
require_once ROOT_PATH . 'vendor/autoload.php';
