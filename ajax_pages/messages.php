<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

if(isset($_POST['seller_id']) ){

  function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
}  

	$seller_id		=input_sanitize($_POST['seller_id']);
	$bidder_id		=input_sanitize($_POST['bidder_id']);
	$product_id		=input_sanitize($_POST['product_id']);
	$msg_id			=input_sanitize($_POST['msg_id']);
	$global_message =input_sanitize($_POST['global_message']);
	$bid_id			=input_sanitize($_POST['bid_id']);
	$flag=0;
	
	if(!empty($global_message)){
	$sql="INSERT INTO messages 
		  SET 
			 product_id	=".$product_id.",
			 seller_id	=".$seller_id.",
			 bidder_id	=".$bidder_id.",
			 message	='".$global_message."',
			 msg_id		=".$msg_id.",
			 bid_id		=".$bid_id.",	
			 msg_date	=CURDATE()";

	mysql_query($sql) or die(mysql_error()."Error in Upload");
	
	$flag=1;
	}	
	
	if($flag==1){
	
		echo "Your message is posted";
	}
	else{
		echo "Your message cannot be posted";
	
	}
	
	
 }
?>