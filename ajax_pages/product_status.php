<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

if(isset($_POST['product_id']) && isset($_POST['delivery_date']) && isset($_POST['courier_name'])){

  function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
  }  

 $product_id	= input_sanitize($_POST['product_id']);
 $delivery_date	= input_sanitize($_POST['delivery_date']);
 $courier_name	= input_sanitize($_POST['courier_name']);
 $tracking_no	= input_sanitize($_POST['tracking_no']);
 $tracking_url	= input_sanitize($_POST['tracking_url']);
 $status		= input_sanitize($_POST['status']); 
  $usr_id=mysql_fetch_array(mysql_query("select user_id from product_info where id=".$product_id));
  $user_id=$usr_id['user_id'];
 $sql = "UPDATE `product_status` 
		SET 
		`delivery_date`    =STR_TO_DATE('".$delivery_date."','%d-%m-%Y'), 
		`courier_name`     = '".$courier_name."', 
		`tracking_no`      = '".$tracking_no."',
		`status`	       ='".$status."',		
		`tracking_url`     = '".$tracking_url."' 
		 WHERE `product_id` =".$product_id; 
		 
		 
	if(mysql_query($sql)){	
		$sql_seller = "UPDATE `seller_info` 
		SET 
		`expired`     = 'N', 
		`status`      = 'Y'
		WHERE `user_id`=".$user_id." and 
		`product_id` =".$product_id;
		 mysql_query($sql_seller);
		echo "Updating done sucessfully<br><b>Click the icon to refresh values</b><a style='margin-left:5px;' href='set_product_status.php'><img src='images/refresh.png'></a>";
	}
	else{
	    echo "Updating cannot be done";
	}
	
}// END OF IF


?>

