<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

if(isset($_POST['username'])){

	$username=$_POST['username'];
	
	if(!empty($username)){
		$sql=mysql_query("SELECT user_name FROM user_info WHERE user_name = '".$username."' UNION SELECT user_name FROM temp_user_info WHERE user_name = '".$username."'");
		//$sql=mysql_query("SELECT user_name FROM `user_info` WHERE user_name='".$username."'");	
		$username_result=mysql_num_rows($sql);
	
	if($username_result==0){
		echo "<font style=\"color:green\">Available</font>";
		$_SESSION['user_status']=1;
	}
	else{
	echo "<font style=\"color:red\">Not Available</font>";
	$_SESSION['user_status']=0;
	
	}	
  }
}

?>