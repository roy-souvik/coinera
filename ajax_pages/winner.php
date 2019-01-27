<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

if(isset($_POST['user_id']) && isset($_POST['remarks'])){

  function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
}  

$flag=1;
$user_id=input_sanitize($_POST['user_id']);
$remarks=input_sanitize($_POST['remarks']);
$product_id=input_sanitize($_POST['product_id']);

$check_remarks=mysql_fetch_array(mysql_query("SELECT `remarks` FROM `buyer_info`WHERE `product_id`=".$product_id." AND `user_id` =".$user_id));

$check_product=mysql_fetch_array(mysql_query("SELECT `status` FROM `product_info` WHERE `id`=".$product_id));

if($check_remarks['remarks']!='' || $check_product['status']=='N'){

	$flag=0;
}




if($flag==1){

$Date = date("Y-m-d");
$expire_date=date('Y-m-d', strtotime($Date. ' + 7 days'));	
$ex_date = date("F j, Y",strtotime($expire_date));  

$count_bids_query=mysql_query("SELECT `product_id`,`bid_price`,`final_bid_price` FROM `bid_info` WHERE `product_id`=".$product_id);
$count_bids=mysql_num_rows($count_bids_query);
	
$PRODUCT_DETAILS=mysql_fetch_array(mysql_query("SELECT `title`,`user_id`,`images`,`bid_price` FROM `product_info` WHERE `id`=".$product_id));
$PRODUCT_IMAGE=$PRODUCT_DETAILS['images'];
$FINAL_PRICE=mysql_fetch_array($count_bids_query);

/********* seller details**********/
$seller_user_id=$PRODUCT_DETAILS['user_id'];
$seller_email_sql=mysql_fetch_array(mysql_query("select `user_name`,`email_id` from `user_info` where `id`=".$seller_user_id));

$seller_email=$seller_email_sql['email_id'];
$seller_user_name=$seller_email_sql['user_name'];
////////////////////////

/********* bidder details**********/
$bidder_email_sql=mysql_fetch_array(mysql_query("select `user_name`,`email_id` from `user_info` where `id`=".$user_id));
$bidder_email=$bidder_email_sql['email_id'];
$bidder_user_name=$bidder_email_sql['user_name'];
////////////////////

$admin_mail_id=mysql_fetch_array(mysql_query("select admin_mail,url from admin_master where admin_id=1"));
$admin_email=$admin_mail_id['admin_mail'];
$url=$admin_mail_id['url'];

/*  SEND MAIL TO THE ADMIN [START] */

$header = 'From: '.$admin_email. "\r\n";
$header.= 'MIME-Version: 1.0' . "\r\n";
$header.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$sub = "CONGRATULATION";


$body="<table width='100%' border='0'>
			  <tr>
				 <td>
					<div>
					   <div align='center' style='height:auto; width:455px;background:#FFFFF0; border:1px #730000 solid;'>
						<table cellspacing='5' cellpadding='0'>
							<tr>
								<td colspan='3' style='border-bottom:1px solid #790000;'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:445px;'></td>
							</tr>
							<tr>
								<td colspan='3' width='25%' align='left' valign='top'>
								<strong>".$seller_user_name."</strong> has selected <strong>".$bidder_user_name."</strong> as a Winner of a Bid for following Product Details.
								</td>
							</tr>
							<tr>
								<td width='25%' align='left' valign='top'>Title</td>
								<td width='1%' align='left' valign='top'>:</td>
								<td width='74%' align='left' valign='top'><strong>".$PRODUCT_DETAILS['title']."</strong></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Bid price</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><strong>Rs. ".$FINAL_PRICE['bid_price']."</strong></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Final price</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><strong>Rs. ".$FINAL_PRICE['final_bid_price']."</strong></td>
							</tr>	
							<tr>
								<td align='left' valign='top'>Image</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><img src='http://arhamcreation.in/coinera/ProductImage/thumbs/$PRODUCT_IMAGE' width='70' height='70'></td>
							</tr>
							<tr>
								<td colspan='3'>This Product purchase date will expire on <font style='color:red'>".$ex_date."</font></td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
							<tr>
								<td colspan='3' align='center' style='color:#FFFFFF; background:#3D1602;'>Copyright &copy; ".date('Y')." Coin Era</td>
							</tr>						
						</table>
					</div>
				</div>
			 </td>
		   <tr>
	    </table>";
	

$m_send_admin=@mail($admin_email, $sub, $body, $header);

/*  SEND MAIL TO THE ADMIN [END] */


/*  SEND MAIL TO THE WINNER [START] */

$headers = 'From: '.$admin_email. "\r\n";
$headers.= 'MIME-Version: 1.0' . "\r\n";
$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$subject = "CONGRATULATION";

$message = "You have won a bid from COIN ERA<br><br>";
$message.="<table width='100%' border='0'>
			  <tr>
				 <td>
					<div>
					   <div align='center' style='height:auto; width:455px;background:#FFFFF0; border:1px #730000 solid;'>
						<table cellspacing='5' cellpadding='0'>
							<tr>
								<td colspan='3' style='border-bottom:1px solid #790000;'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:445px;'></td>
							</tr>
							<tr><td colspan='3'> Details of the product are given below</td></tr>
							<tr>
								<td width='25%' align='left' valign='top'>Title</td>
								<td width='1%' align='left' valign='top'>:</td>
								<td width='74%' align='left' valign='top'><strong>".$PRODUCT_DETAILS['title']."</strong></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Final price</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><strong>Rs. ".$FINAL_PRICE['final_bid_price']."</strong></td>
							</tr>
							<tr>
								<td align='left' valign='top'>Remarks</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><strong>".$remarks."</strong></td>
							</tr>	
							<tr>
								<td align='left' valign='top'>Image</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'><img src='http://arhamcreation.in/coinera/ProductImage/thumbs/$PRODUCT_IMAGE'  width='70' height='70'></td>
							</tr>						
							<tr>
								<td colspan='3'>Please contact the site admin and pay the amount as soon as possible.</td>
							</tr>
							<tr>
								<td colspan='3'>You have to purchase this product on or before <b style='color:red;'>".$ex_date."</b></td>
							</tr>
							<tr>
								<td colspan='3'>Please <a href='".$url."single_login.php'>Login</a> and go to your <u>Products Won</u> section from <u>Bid Details Area</u>.</td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>							
							<tr>
								<td colspan='3'>Regards,<br><strong>Coin Era Team</strong></td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
							<tr>
								<td colspan='3' align='center' style='color:#FFFFFF; background:#3D1602;'>Copyright &copy; ".date('Y')." Coin Era</td>
							</tr>
						</table>
					</div>
				</div>
			 </td>
		   <tr>
	    </table>";
	

$m_send_bidder=@mail($bidder_email, $subject, $message, $headers);
/*  SEND MAIL TO THE WINNER [END] */

if($m_send_bidder){
		
	mysql_query("UPDATE `buyer_info` SET `remarks` = '".$remarks."' WHERE `product_id`=".$product_id." AND `user_id`=".$user_id);
	
	mysql_query("UPDATE `product_info` SET `bid_status` = 'N',`status` = 'N' WHERE `id`=".$product_id);  
	
		
	mysql_query("INSERT INTO `product_status` (`product_id`, `winner_id`, `bid_count`, `expire_date`) VALUES ($product_id, $user_id, $count_bids, '".$expire_date."')");
	
	echo "<h3>Your request is submitted <br/> An email is sent to the bidder.</h3>";
}else{
	echo "<h3>Your request is not submitted <br/> Unable to send email to the bidder.</h3>";
}

} //END OF IF CONDITION WHERE flag=1


if($flag==0){

	echo "<h3>Unable to process your request <br/>A winner is already declared</h3>";

}


}

?>