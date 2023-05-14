<?php
ob_start();

date_default_timezone_set('Asia/Bangkok');
session_start();

// Unset Session Variables
unset($_SESSION["account_role"]);
unset($_SESSION["account_id"]);
// Clear Session
session_unset();
session_destroy();

?>

<script>
    location.assign("./../../view/OAuth/login.php");
</script>