<?php

$api = '86444d9c-e72e-4323-bf96-d3da90d39ed4'; // تست ، کلید مجوز دهی خود را وارد نمایید
$api = isset($user_pay) ? $user_pay : $api ;

$order_id = $code;
$CallbackURL = ''.$setting_site.'/page.php?id=pay';
$amount = $price;
include_once "nextpay_payment.php";

$nextpay = new Nextpay_Payment(array(
				      "api_key"=>$api,
				      "order_id"=>$order_id,
				      "amount"=>$amount,
				      "callback_uri"=>$CallbackURL));

$res = $nextpay->token();

if (intval($res->code) == -1) {
    
    mysql_query("UPDATE `pay` SET `code`='{$res->trans_id}' WHERE `id`='$pid'");
    $nextpay->send($res->trans_id);
    
} else {
    
    $errorMsg = '<div class="error"><b>خطا 1 : </b> اتصال انجام نشد : '.$nextpay->code_error(intval($res->code)).'</div>';
    
}

?>
