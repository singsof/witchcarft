<?php 


// session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../App/config/connectdb.php';
require_once __DIR__ . '/../../../App/models/Products.php';
require_once __DIR__ . '/../../../App/models/Accounts.php';
require_once __DIR__ . '/../../../App/models/Comments.php';
require_once __DIR__ . '/../../../App/models/TarotCards.php';
require_once __DIR__ . '/../../../App/models/RelationCardProducts.php';


$Dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'\\..\\..\\..\\');
$Dotenv->load();


?>