<?php
ob_start(); 
session_start();
include("includes/config.php");
include("includes/dbcon.php");
?>

<?php
if(isset($_REQUEST['activationkey']) && !empty($_REQUEST['activationkey']))
{
	//echo "select user_id,password,email_id from temp_user where activation_code='".$_REQUEST['activationkey']."'";
	$result=mysql_fetch_array(mysql_query("select * from temp_user_info where activation_code='".$_REQUEST['activationkey']."'"));
if(!isset($result['activation_code'])){
	$_SESSION['active_msg']="Sorry ! Invalid Activation Link.";
	header("Location:index.php");
	}else{
			
	$sql="INSERT INTO `user_info`
		SET 
			first_name 		= '".$result['first_name']."',
			last_name	  	= '".$result['last_name']."',
			user_name 	  	= '".$result['user_name']."',
			password 	  	= '".$result['password']."',
			email_id 	  	= '".$result['email_id']."',
			date_of_birth 	= '".$result['date_of_birth']."',
			address		    = '".$result['address']."',
			city 	  		= '".$result['city']."',
			zip_code	  	= '".$result['zip_code']."',
			state 	  		= '".$result['state']."',
			country 	  	= '".$result['country']."',
			phone 	  		= '".$result['phone']."',
			image 		  	= '".$result['image']."',
			remarks 		= '".$result['remarks']."',
			entry_date		= CURDATE()";
	
		$rows=mysql_query($sql) or die(mysql_error()."Error in Upload");
		if(mysql_affected_rows()>0)
		{
			$query_delete=mysql_query("delete from temp_user_info where activation_code='".$_REQUEST['activationkey']."'");
			
			if(mysql_affected_rows()>0)
			{ 	
				$_SESSION['active_msg']="Congratulations! Your account has been Activated Successfully. Please Login To Access";
				header("Location:single_login.php"); 
			}
		}
	}
}

?>