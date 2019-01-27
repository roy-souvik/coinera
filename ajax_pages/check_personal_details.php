<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

$GLOBALS['msg']='';
$GLOBALS['msg_user']='';
$GLOBALS['user_status_msg']='';
/* if(isset($_POST['update'])){

$flag=1;

 function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
} 
if(
   strlen(input_sanitize($_POST['first_name']))==0 
|| strlen(input_sanitize($_POST['last_name']))==0
|| strlen(input_sanitize($_POST['user_name']))==0
|| strlen(input_sanitize($_POST['email_id']))==0
|| strlen(input_sanitize($_POST['password']))==0
|| strlen(input_sanitize($_POST['zip_code']))==0
|| strlen(input_sanitize($_POST['confirm_password']))==0
|| strlen(input_sanitize($_POST['country']))==0
|| strlen(input_sanitize($_POST['address']))==0
|| strlen(input_sanitize($_POST['city']))==0
|| strlen(input_sanitize($_POST['phone']))==0
  ){
	$GLOBALS['msg'] = "There are some error(s) in the form";
	$flag=0;
}

if($_POST['password']!=$_POST['confirm_password']){
	$GLOBALS['msg'] = "Password & confirm passwords are different";
	$flag=0;
}

if((!filter_var($_POST['phone'], FILTER_VALIDATE_INT)) || (!filter_var($_POST['zip_code'], FILTER_VALIDATE_INT))){
	$GLOBALS['msg'] = "Enter only integers in phone number and zip code fields";
	$flag=0;
}


if(!filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL)){
	$GLOBALS['msg'] = "Enter a valid email id";
	$flag=0;
}

if(!filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL)){
	$GLOBALS['msg'] = "Enter a valid paypal email id";
	$flag=0;
}

if($_SESSION['user_status']!=1){
	$GLOBALS['user_status_msg']='User name not available';
	$flag=0;
} 

if($flag==1){

$date_of_birth =$_POST['day']."-".$_POST['month']."-".$_POST['year'];

$filename=upload_image(realpath('ProfileImage/normal/'),realpath('ProfileImage/thumbs/'));

$sql="UPDATE `user_info`
		SET 
			first_name 		= '".input_sanitize($_POST['first_name'])."',
			last_name	  	= '".input_sanitize($_POST['last_name'])."',
			user_name 	  	= '".input_sanitize($_POST['user_name'])."',
			password 	  	= '".input_sanitize($_POST['password'])."',
			email_id 	  	= '".input_sanitize($_POST['email_id'])."',
			date_of_birth 	= STR_TO_DATE('".$date_of_birth."','%d-%m-%Y'),
			address		    = '".input_sanitize($_POST['address'])."',
			city 	  		= '".input_sanitize($_POST['city'])."',
			zip_code	  	= '".input_sanitize($_POST['zip_code'])."',
			state 	  		= '".input_sanitize($_POST['state'])."',
			country 	  	= '".input_sanitize($_POST['country'])."',
			phone 	  		= '".input_sanitize($_POST['phone'])."',
			image 		  	= '".$filename."',
			remarks 		= '".input_sanitize($_POST['remarks'])."',
			paypal_email 	= '".input_sanitize($_POST['paypal_email'])."'";

		mysql_query($sql) or die(mysql_error()."Error in Upload"); 

	$GLOBALS['msg'] = "Information updated Successfully";
 }//end of if condition where flag=1
 
}//end of if condition



$user_id = $_SESSION['user_id'];

$user_details = mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$user_id));
$id=$user_details['id'];
$first_name=$user_details['first_name'];
$last_name=$user_details['last_name'];
$user_name=$user_details['user_name'];
$email_id=$user_details['email_id'];
$date_of_birth=$user_details['date_of_birth'];
$address=$user_details['address'];
$city=$user_details['city'];
$zip_code=$user_details['zip_code'];
$state=$user_details['state'];
$country=$user_details['country'];
$phone=$user_details['phone'];
$image=$user_details['image'];
$email_id=$user_details['email_id'];
$paypal_email=$user_details['paypal_email']; */



echo"saddasdasdasd ";


?>
