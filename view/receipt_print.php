<?php
use Phattarachai\Thaidate\Thaidate;
ob_start();
?>


<?php
date_default_timezone_set('Asia/Bangkok');

require_once dirname(__FILE__) . '/../App/config/connectdb.php';


session_start();

$id = $_GET["id"] ?? null;
if ($id === null) {
    echo "<script>window.history.back(-1)</script>";
}

$sql = "SELECT * FROM `reservation` as res INNER JOIN user as us ON us.user_id = res.user_id INNER JOIN court as cou ON cou.court_id = res.court_id WHERE res.reservation_id = '$id'";
$resulte = DB::query($sql, PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

$start = new DateTime($resulte->start_time);
$end = new DateTime($resulte->end_time);
$interval = $start->diff($end);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ใบเสร็จรับเงินค่าสมาชิกรายเดือน</title>

    <style type="text/css" media="print">
        #paper {
            width: 21cm;
            min-height: 25cm;
            padding: 2.5cm;
            position: relative;
        }
    </style>

    <style type="text/css" media="screen">
        #paper {
            background: #FFF;
            border: 1px solid #666;
            margin: 20px auto;
            width: 21cm;
            min-height: 25cm;
            padding: 50px;
            position: relative;

            /* CSS3 */

            box-shadow: 0px 0px 5px #000;
            -moz-box-shadow: 0px 0px 5px #000;
            -webkit-box-shadow: 0px 0px 5px #000;
        }
    </style>
    <style type="text/css">
        #paper textarea {
            margin-bottom: 25px;
            width: 50%;
        }

        #paper table,
        #paper th,
        #paper td {
            border: none;
        }

        #paper table.border,
        #paper table.border th,
        #paper table.border td {
            border: 1px solid #666;
        }

        #paper th {
            background: none;
            color: #000
        }

        #paper hr {
            border-style: solid;
        }

        #signature {
            bottom: 181px;
            margin: 50px;
            padding: 50px;
            position: absolute;
            right: 3px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="paper">
        <table width="100%">
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <h1 align="center">ใบเสร็จชำระเงิน</h1>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <?php echo $_ENV['APP_NAME'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <?php echo $_ENV['ADDRESS'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">โทร
                    <?php echo $_ENV['PHONE'] ?>
                </td>
            </tr>

            <tr>
                <td align="">เมล
                    <?php echo $_ENV['MAIL']; ?>
                </td>
                <td align="right">

                </td>
            </tr>
            <tr>
                <td>รหัสสมาชิก :
                    <?php echo $resulte->id_card; ?>
                </td>
                <td width="33%" align="right">วันที่จอง <br>
                    <?php echo Thaidate('j F Y', $resulte->reservation_date) ?> <br> เวลา
                    <?php echo $resulte->start_time . ' - ' . $resulte->end_time; ?> น.
                </td>
            </tr>
            <tr>
                <td>ชื่อ :
                    <?php echo $resulte->name; ?>
                </td>
                <td width="33%" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td>ที่อยู่ :
                    <?php echo $resulte->address; ?>
                </td>
                <td align="right">
                    ออกใบเสร็จเมื่อ <br><?php echo thaidate("j F Y H:i น. ",$resulte->timestamp_res) ; ?>
                </td>
            </tr>
        </table>
        <table width="100%" class="border">
            <tr>
                <td width="30" align="center">ลำดับ </td>
                <td align="center">รายการ </td>
                <td width="200" align="center">จำนวน ( บาท )</td>
            </tr>
            <tr>
                <td align="center">1</td>
                <td>
                    <?php echo $resulte->court_name . ' จำนวน ' . $interval->format('%h ชั่วโมง %i นาที'); ?>
                </td>
                <td align="right">
                    <?php echo $resulte->total_price;  ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">จำนวนเงิน</td>
                <td align="right">
                    <?php echo $resulte->total_price; ?>
                </td>
            </tr>
        </table>
        <table width="30%" align="right">
            <tr>
                <td align="center"></td>
            </tr>
            <tr>
                <td align="center"></td>
            </tr>
            <tr>
                <td align="center"></td>
            </tr>
            <tr>
                <td align="center">................................</td>
            </tr>
            <tr>
                <td align="center">(
                    <?php echo $_ENV['APP_NAME'] ?> )
                </td>
            </tr>
            <tr>
                <td align="center">ผู้รับเงิน </td>
            </tr>
        </table>

    </div>
</body>

</html>