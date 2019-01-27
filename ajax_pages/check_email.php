<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

if(isset($_POST['email_id'])){

	$email_id=$_POST['email_id'];
	
	if(!empty($email_id)){
$sql=mysql_query("SELECT email_id FROM user_info WHERE email_id = '".$email_id."' UNION SELECT email_id FROM temp_user_info WHERE email_id = '".$email_id."'");	
		
		//$sql=mysql_query("SELECT email_id FROM `user_info` WHERE email_id='".$email_id."'");	
		$email_id_result=mysql_num_rows($sql);
	
	if($email_id_result==0){
		
		$_SESSION['email_id_status']=1;
	}
	else{
	echo "Sorry this email is already in our records";
	$_SESSION['email_id_status']=0;
	
	}	
  }
}

?>