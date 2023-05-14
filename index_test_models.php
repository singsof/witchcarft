<?php
require_once __DIR__ . '/./App/config/connectdb.php';
require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once __DIR__ . '/./App/models/Accounts.php';
require_once __DIR__ . '/./App/models/Comments.php';
require_once __DIR__ . '/./App/models/Products.php';
require_once __DIR__ . '/./App/models/TarotCards.php';
require_once __DIR__ . '/./App/models/RelationCardProducts.php';
require_once __DIR__ . '/./App/models/Comments.php';
require_once __DIR__ . '/./App/models/OrdersDetails.php';
require_once __DIR__ . '/./App/models/Orders.php';
require_once __DIR__ . '/./App/models/Payments.php';
$Dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$Dotenv->load();



use Leaf\Form;
?>

<?php
$result = new stdClass();
date_default_timezone_set('Asia/Bangkok');
$insert = new Accounts();
$insert->setAccount_name('SOMPHOL WILA');
$insert->setAccount_email('singsoft.sw1@gmail.com');
$insert->setAccount_address('-');
$insert->setAccount_password('s1234', true);
$insert->setAccount_phone('0961632545');
// $isCheckInsertData = $insert->insertAccounts(); // boolean
// OutputJson($insert->response);
// OutputJson($insert->getShowAccountsAll());
// $resultAccounts = $insert->getShowAccountsAll(PDO::FETCH_ASSOC);

// $issetEmailInData  = array_filter(
//     $resultAccounts,
//     function ($account) use ($insert) {
//         return $account['account_email'] === $insert->getAccount_email();
//     }
// );


// $isCheckData = false || false || false|| false || false ;


// var_dump($insert->getShowAccountsAll());

// $da->updateAccounts();
// var_dump($insert->getShowAccountsAll());
// $resultAccounts = $insert->getShowAccountsAll(PDO::FETCH_ASSOC) == false ? [] : $insert->getShowAccountsAll(PDO::FETCH_ASSOC);
// var_dump($resultAccounts);
// // ตรวจสอบมีในฐานข้อมูล คือค่า เป็็น false ไม่มีในฐานข้อมูล คือว่าเป้น true คือสามารถเพืิ่มได้
// $issetEmailInData  = array_reduce(array_filter(
//     $resultAccounts,
//     function ($account) use ($insert) {
//         return $account === $insert->getAccount_email();
//     }
// ), function () {
//     return true;
// }, false);

// if ($issetEmailInData) {
//     $result->status = 'error';
//     $result->msg = 'error! :  ' . 'Email นี้เคยใช้สมัครแล้ว';
//     $insert->response = $result;
// }
// print_r($insert->response);

$update = new Accounts();
$update->setAccount_id(16);
$update->setAccount_name('SOMPHOL WILA');
$update->setAccount_email('singsoft.sw@gmail.com');
$update->setAccount_address('--');
$update->setAccount_password('1234');
$update->setAccount_phone('0961632545');
$update->setAccount_role('user');
$update->setAccount_status('show');
// $update->updateAccounts();


// OutputJson($da->getAllAccounts())

$login = new Accounts();
$login->setAccount_email(Form::sanitizeInput('singsoft.swgmail'));
$login->setAccount_password('s1234', false);
// $isCheckLogin = $login->verifyAccountLogin();
// print_r($update->response) ;

// print_r($login->getShowAccountsOne(16));


// var_dump($validation);
// // $dd = $login->verifyAccount_password($hashedPassword);
// var_dump($dd);


// var_dump($login->verifyAccountLogin());
// var_dump($login->response);
// $plainPassword = "myPassword123"; // Plain text password
// $hashedPassword = '$2y$10$DKkNKZTeJ830kd1gSe4QEumt3khMCQLrg38UNW/xTPcUX4jL5QwKq';

// $plainPassword = "myPassword123"; // Plain text password

// $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
// echo $hashedPassword;

// $plainPassword = "myPassword123"; // Plain text password

// if (password_verify($plainPassword, $hashedPassword)) {
//     echo "Password is valid."; // Password is valid.
// } else {
//     echo "Password is invalid.";
// }

// $login->verifyAccount_password($plainPassword);
// $date = date('Y-m-d');
// $start_time = date('H:i', '17:00');
// $datetime2 = new DateTime('03-03-2023 10:00 AM');



// $dateN = date('Y-m-d');
// $TimeN = date('H:i', strtotime('+60 minutes'));
// $TimeEP = date('H:i', strtotime('+100 minutes'));

// // $da = new DateTime($dateN);
// // print_r($da->format('H:i:s'));

// $datetime1 = new DateTime("2023-03-20 17:02");
// $datetime2 = new DateTime("$dateN $TimeN");

// // 2023-03-20 03:13 - 17:02
// var_dump($datetime1 < $datetime2);

// echo "<script>window.location.assign('./view/OAuth2/sign-in.php');</script>";



$comment = new Comments();
// $comment->getShowCommentsAll();

$product_insert = new Products();
// $product_insert->setProduct_key(2);
// $product_insert->setProduct_name('nameTestc');
// $product_insert->setProduct_picture('test.jpg');
// $product_insert->setProduct_stock('20');
// $product_insert->setProduct_detail('-');
// $product_insert->setProduct_price('100');
// $product_insert->deleteProducts();
// OutputJson($product_insert->response);

$showOne = $product_insert->getShowProductsOne(7);
// OutputJson($showOne);

// $showAll = $product_insert->getShowProductsAll();

// OutputJson($showAll);

$product_update = new Products();
$product_update->setProduct_key(12);
// $product_update->setProduct_name('nameTest');
// $product_update->setProduct_picture('test.jpg');
// $product_update->setProduct_stock('20');
// $product_update->setProduct_detail('-');
$product_update->setProduct_price('10000');
// $product_update->updateProducts();
// OutputJson($product_update->response);


$product_delet = new Products();
$product_delet->setProduct_key(12);
// $product_delet->setProduct_name('nameTest');
// $product_delet->setProduct_picture('test.jpg');
// $product_delet->setProduct_stock('20');
// $product_delet->setProduct_detail('-');
// $product_delet->setProduct_price('10000');
// $product_delet->deleteProducts();
// OutputJson($product_delet->response);

$card_insert = new TarotCards();
$card_insert->setcard_name('nameTestx');
$card_insert->setcard_picture('test.jpg');
$card_insert->setCard_meaning('-');
$card_insert->setcard_detail('-');
// $card_insert->insertTarotCards();
// $data = $card_insert->getShowTarotCardsAll();

// var_dump($card_insert->response);
// OutputJson($data);
$TarotCards_update = new TarotCards();
$TarotCards_update->setCard_key(10);
$TarotCards_update->setCard_name('THE FOOL');
$TarotCards_update->setCard_picture('test.jpg');
$TarotCards_update->setCard_meaning('20');
$TarotCards_update->setCard_detail('-');
// $TarotCards_update->deleteTarotCards();
// OutputJson();
// foreach ($TarotCards_update->response as $key => $value) {
//     OutputJson($value->relation_key);

// }
// OutputJson($TarotCards_update->response);

$relation_insert = new RelationCardProducts();
$relation_insert->setCard_key(1);
$relation_insert->setProduct_key(1);
// $relation_insert->setCard_key(10);
// $relation_insert->setProduct_key(7);
// $relation_insert->insertRelationCardProducts();
// OutputJson($relation_insert->response);

$relation_update = new RelationCardProducts();
$relation_update->setRelation_key(33);
$relation_update->setCard_key(10);
$relation_update->setProduct_key(8);
// $relation_update->updateRelationCardProducts();
// OutputJson($relation_update->response);
// $data = $relation_update->getShowRelationCardProductsCardAllKey('product_key',9);
// OutputJson($data);



$Comments_insert = new Comments();
$Comments_insert->setComment_key(5);
$Comments_insert->setComment_title('สวยมาก');
$Comments_insert->setComment_detail('-');
$Comments_insert->setProduct_key(1);
$Comments_insert->setaccount_key(24);
$Comments_insert->setComment_status('show');
// $Comments_insert->updateComments();
// OutputJson($Comments_insert->response);

// $data = $Comments_insert->getShowCommentsCardAllKey(null,1);
// OutputJson($data);


$Orders_insert = new Orders();
$Orders_insert->setOrder_key(3);
// $Orders_insert->setOrder_code(20);/
$Orders_insert->setAccount_key(24);
$Orders_insert->setOrder_price(10000);
$Orders_insert->setOrder_price_delivery(50);
// $Orders_insert->setOrder_delivery('ที่อยู่-');
// $Orders_insert->setOrder_status('success');


// $Comments_insert->updateComments();
// OutputJson($Comments_insert->response);

// $data = $Orders_insert->getShowPaymentsAllKey(null,3);
// OutputJson($data);
// OutputJson($Orders_insert->response);

$OrderDetails_insert = new OrderDetails();
$OrderDetails_insert->setOrder_key(3);
// $OrderDetails_insert->setOrder_code(20);/
// $OrderDetails_insert->setAccount_key(24);
// $OrderDetails_insert->setOrder_price(10000);
// $OrderDetails_insert->setOrder_price_delivery(50);
// $OrderDetails_insert->setOrder_delivery('ที่อยู่-');
// $OrderDetails_insert->setOrder_status('success');


// $Comments_insert->updateComments();
// OutputJson($Comments_insert->response);

// $data = $OrderDetails_insert->getShowOrderDetailsAllKey('order_key',$OrderDetails_insert->getOrder_key());
// OutputJson($data);
// OutputJson($OrderDetails_insert->response);


$Payments_insert = new Payments();
$Payments_insert->setPayment_key(3);
$Payments_insert->setPayment_key(3);
$Payments_insert->setPayment_amount(3);
// $Payments_insert->setPayment_method();
// $Payments_insert->setPayment_currency(3);


// $data = $Payments_insert->getShowPaymentsAll();
// OutputJson($data);
// OutputJson($Payments_insert->response);
?>


