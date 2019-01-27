<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
session_start();
header('Cache-Control: private');
require("../includes/config.php");
require("../includes/dbcon.php");
require("../includes/functions.php");
if($_SESSION['admin_userid']==''){
	header('Location: index.php');
}

if(isset($_POST['seller_email']) && isset($_POST['message'])){

 function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
}


$image=$_POST['image'];
$title=$_POST['title'];
$message2=$_POST['message'];

$buyer_name=$_POST['buyer_name'];
$buyer_address=$_POST['buyer_address'];
$buyer_phone=$_POST['buyer_phone'];

$buyer_id=$_POST['buyer_id'];
$seller_id=$_POST['seller_id'];
$product_id=$_POST['product_id'];

$admin_mail=mysql_fetch_array(mysql_query("select admin_mail from admin_master where admin_id =1"));
		$fromEmail=$_POST['seller_email'];
		
		$email=$admin_mail['admin_mail'];

	   $message="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
					<td>
					<div><div align='center' style='height:auto; width:450px;background:#FFFFFF; border:1px #19709D solid;'>
						<table width='100%' cellpadding='5px' cellspacing='0'>
							<tr>
								<td colspan='3'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:440px;'></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Title</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$title."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Image</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><img style='width:100px;' src='http://arhamcreation.in/coinera/ProductImage/thumbs/$image'></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Message</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".input_sanitize($message2)."</td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
							<tr>
								<td colspan='3'><h3>Buyer Information</h3></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Full Name</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$buyer_name."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Full Address</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$buyer_address."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Contact Number</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$buyer_phone."</td>
							</tr>
							
						</table>
					</div></div>
					</td>
					<tr>
					</table>";
					
	   $to = $fromEmail;
	   $subject = "Reminder to send the product";
	   $headers = 'From: '.$email. "\r\n";
	   $headers.= 'MIME-Version: 1.0' . "\r\n";
	   $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	   
$MAIL_STATUS=mysql_query("SELECT user_id,product_id FROM `seller_info` WHERE user_id=".$seller_id." AND product_id=".$product_id);
	
if(mysql_num_rows($MAIL_STATUS)==0){	   
	   
 if(mail($to, $subject, $message, $headers)){

/* ======================================================================================================= */ 
/* ==================== INSERT INTO DATABASE [START]==================================== */

$sql="INSERT INTO `notification`
		SET 
			buyer_id 		= ".input_sanitize($buyer_id).",
			seller_id	  	= ".input_sanitize($seller_id).",
			product_id 	  	= ".input_sanitize($product_id).",
			admin_msg 	  	= '".input_sanitize($message2)."',
			send_date		= CURDATE()";

		mysql_query($sql) or die(mysql_error()."Error in Upload");
	   
/* ==================== INSERT INTO DATABASE [END]==================================== */
$Date = date("Y-m-d");
$expire_date=date('Y-m-d', strtotime($Date. ' + 7 days'));

	$sql2="UPDATE product_status
	   SET
		start_date=CURDATE(),
		end_date='".$expire_date."' WHERE product_id=".$product_id." AND winner_id=".$buyer_id;

		mysql_query($sql2) or die(mysql_error()."Error in Upload");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
	$sql3="INSERT INTO seller_info
		   SET
		     user_id=".$seller_id.",
			 product_id=".$product_id;

	mysql_query($sql3) or die(mysql_error()."Error in Upload");

/* ======================================================================================================= */ 
	 echo "Mail sent sucessfully";
  }		
		
 else{
   echo "Unable to send the mail";
 }

}// END OF IF FOR CHECKING MAIL STATUS
	else{
	
	  echo"<center><h3>You have already sent a mail previously</h3></center>";
	}


}

?>