<?php
/* Start the Session */
session_start();

/* Set Default Timezone */
date_default_timezone_set('Asia/Jakarta');

/* Initiate the Application */
require_once dirname(__DIR__) . '/app/autoload.php';
