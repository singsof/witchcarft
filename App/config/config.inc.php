<?php
ob_start();
date_default_timezone_set('Asia/Bangkok');


require_once dirname(__FILE__) . '/../../vendor/autoload.php';
$Dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'\\..\\..\\');
$Dotenv->load();

use Phattarachai\Thaidate;



define("DB_TYPE", "MySQL"); // MySQL & SQLite
define("DB_HOST", $_ENV['HOST']);

define("DB_USERNAME", $_ENV['USERNAME']);
define("DB_PASSWORD", $_ENV['PASSWORD']);
define("DB_NAME", $_ENV['DATABASE']);

define("DB_DNS_MYSQL", "mysql:host=" . DB_HOST . "; dbname=" . DB_NAME);
define("DB_DNS_SQLITE", "sqlite:db/sqlite_file");
    // define("DB_PREFIX", "face_detection");

