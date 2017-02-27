<?php
//ini_set('display_errors', true);

$api = '86444d9c-e72e-4323-bf96-d3da90d39ed4'; // تست ، کلید مجوز دهی خود را وارد نمایید
$api = isset($user_pay) ? $user_pay : $api ;

$trans_id = isset($_POST['trans_id']) ? $_POST['trans_id'] : false ;
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : false ;
if($trans_id && $order_id){

	include_once "nextpay_payment.php";

	$sql = mysql_query("SELECT * FROM `pay` WHERE `code`='$trans_id' AND `done`='1'");
	$check_it = mysql_num_rows($sql);


	$sql = mysql_query("SELECT * FROM `pay` WHERE `code`='$trans_id'");
	$row = mysql_fetch_array($sql);
	$amount = filterget($row["amount"]);

	$parameters = array
	(
	    'api_key'	=> $api,
	    'trans_id' 	=> $trans_id,
	    'order_id' 	=> $order_id,
	    'amount'	=> $amount
	);

	$nextpay = new Nextpay_Payment();
	$Result = intval($nextpay->verify_request($parameters));

	if ($Result == 0) {
	    $ok = 0;
	}else if($check_it > 0){
	  $ok = 1;
	  $errorMsg = '<div class="error"><b>خطا 1 : </b> این تراکنش قبلا اجرا شده است</div>';
	} else {
	    $ok = 2;
	}
}
?>