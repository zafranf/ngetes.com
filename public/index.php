<?php
/* Start the Session */
session_start();

/* Set Default Timezone */
date_default_timezone_set('UTC');

/* Define Public Path */
define('PUBLIC_PATH', __DIR__ . '/');

/* Initiate the Application */
require_once '../app/autoload.php';
