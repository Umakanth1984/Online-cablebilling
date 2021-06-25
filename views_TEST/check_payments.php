<div class="content-wrapper">
<div class="box-body"> 
<?php
//These should be commented out in production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//Load API, Ideally it should installed by composer and autoloaded if your project uses composer
// require('razorpay-php/Razorpay.php');
require_once APPPATH."/third_party/razorpay-php/Razorpay.php";

use Razorpay\Api\Api;

//Use your key_id and key secret
$api = new Api('rzp_live_FUvOIwfOBMSlWM', 'kiuHnSqO7UmS8JFx5tKtiugk');
//$api = new Api('rzp_test_Dd9YeK0M0MxJwZ', 'H2jWpTDSUc7hfJIEHlRVEybs');

//This is submited by the checkout form
if (isset($_POST['razorpay_payment_id']) === false)
{
    die("Payment id not provided");
}

$id = $_POST['razorpay_payment_id'];
$amtSent=($_POST['orderAmount']*100);
//capture Rs 5100
$payment = $api->payment->fetch($id)->capture(array('amount'=>$amtSent));

//echo response	
json_encode($payment->toArray());
 
$objRes =json_decode(json_encode($payment->toArray()));
extract($payment->toArray()); 
print_r($payment->toArray());
$trasNotes=json_encode($notes);
extract($notes);
 $amtCredited=$amount/100;
// Custome code
			extract($_REQUEST);
			print_r($_REQUEST);
			 $data = array(
					//"isAdjustment" =>$REQUEST['isAdjustment'],
					"customer_id" =>$cust_id,
					"emp_id" =>$emp_id,
					"amount_paid" =>$amtCredited,
					"grp_id" => $grp_id,
					"transaction_type" => "card",
					"invoice" => $invoice_id,
					"cheque_number" => $cheque_number,
					"bank" => $bank,
					"branch" => $branch,
					"instrument_date" => $idate,
					"remarks" => $remarks,
					"dateCreated" => date('Y-m-d H:i:s')
				);
			$this->db->insert("payments", $data);
			$updateAmt=$pendingAmt - $amtCredited;
			$data1 = array(
					"pending_amount" =>$updateAmt,
					"current_due" =>$updateAmt,
					);
			$this->db->where('cust_id',$cust_id);
			$this->db->update('customers', $data1);
			
			$trnsData=array(
						"id" => $id,
						"entity" => $entity,
						"amount" => ($amount/100),
						"currency" => $currency,
						"status" => $status,
						"order_id" => $order_id,
						"invoice_id" => $invoice_id,
						"international" => $international,
						"method" => $method,
						"amount_refunded" => $amount_refunded,
						"refund_status" => $refund_status,
						"captured" => $captured,
						"description" => $description,
						"card_id" => $card_id,
						"bank" => $bank,
						"wallet" => $wallet,
						"vpa" => $vpa,
						"email" => $email,
						"contact" => $contact,
						"notes" => $trasNotes,
						"fee" => $fee,
						"service_tax" => $service_tax,
						"error_code" => $error_code,
						"error_description" => $error_description,
						"created_at" => $created_at,
						"dateCreated"=>date('Y-m-d H:i:s')
				);
				$this->db->insert("online_transactions", $trnsData);
				
				
			//if($transactionType==1){ $transType="Cash";}elseif($transactionType==2){$transType="Bank / Cheque";}
			$resCust=mysql_fetch_assoc(mysql_query("SELECT first_name,mobile_no FROM customers WHERE cust_id=$cust_id"));
			$selSenderID=mysql_fetch_assoc(mysql_query("SELECT sender_ids.sender_name FROM sender_ids RIGHT JOIN groups ON sender_ids.sender_id=groups.sender_id WHERE groups.group_id=$grp_id"));
			 $resSenderID=$selSenderID['sender_name'];
			 
			$busInfo=mysql_fetch_assoc(mysql_query("SELECT * FROM business_information"));
			$custName=$resCust['first_name'];
			$busiName=$busInfo['business_name'];

			//echo $resCust['mobile_no'];
			$resSmsPrefer=mysql_fetch_assoc(mysql_query("SELECT * FROM sms_prefer"));
			 
			// Send SMS
			if(($resSmsPrefer['sendsms']=='Yes') && ($resSmsPrefer['sendpaymentsms']=='Yes')){

				//$mess = urlencode("Your Payment Rs.".$amount." received by ".$transType." towards Outstanding Cable Bill. Invoice No ".$invoice);
				$mess = urlencode("Dear ".ucwords($custName).",Thank you for your Payment for the sum of Rs.".$amount." towards your Cable TV Bill Receipt No : ".$invoice." total Outstanding Rs.".$updateAmt." - ".ucwords($busiName));
				$url = $resSmsPrefer['sms_api_url']."&sender=".$selSenderID['sender_name']."&number=".$resCust['mobile_no']."&message=" . $mess; 
				//$url = "http://www.bulksmsapps.com/apisms.aspx?user=DIGITALRUPAY&password=Digital@1&genkey=195470434&sender=DRUPAY&number=".$resCust['mobile_no']."&message=" . $mess;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // TODO - UNCOMMENT IN PRODUCTION
				curl_close ($ch);
			}
			// End of SMS
			 
// end of Custome code

//Payment is captured, do whatever else you need to do
// Mark order as done using the submitted hidden field
$shopping_order_id = $shopping_order_id;
$invoice_id = $invoice_id;
 redirect('customer_dashboard/payment_history/?msg=1');
// markOrderAsDone($shopping_order_id);
?>
 
</div>
</div>