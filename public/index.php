<?php
/* Start the Session */
session_start();

/* Set Default Timezone */
date_default_timezone_set('Asia/Jakarta');

/* Define Public Path */
define('PUBLIC_PATH', __DIR__ . '/');

/* Initiate the Application */
require_once '../app/autoload.php';
