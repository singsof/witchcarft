<?php 


// session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../App/config/connectdb.php';
require_once __DIR__ . '/../../../App/models/Products.php';
require_once __DIR__ . '/../../../App/models/Accounts.php';
require_once __DIR__ . '/../../../App/models/Comments.php';
require_once __DIR__ . '/../../../App/models/TarotCards.php';
require_once __DIR__ . '/../../../App/models/RelationCardProducts.php';
require_once __DIR__ . '/../../../App/models/Orders.php';
require_once __DIR__ . '/../../../App/models/OrdersDetails.php';
require_once __DIR__ . '/../../../App/models/Payments.php';


$Dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'\\..\\..\\..\\');
$Dotenv->load();

// echo $_SESSION["account_role"];

if (empty($_SESSION["account_role"])):
    echo "<script>window.location.assign('../../App/controllers/authLogout.php')</script>";
endif;

if (empty($_SESSION["account_id"])) :
    echo "<script>window.location.assign('../../App/controllers/authLogout.php')</script>";
endif;

$_Role = $_SESSION["account_role"] == "user" ? $_SESSION["account_role"] : false;

if(!$_Role){
    echo "<script>window.location.assign('../../App/controllers/authLogout.php')</script>";
}


$_Account_id = $_SESSION["account_id"];

$_Account = new Accounts();
$_Account->getShowAccountsOne($_Account_id);



?>