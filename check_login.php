<?php
ob_start();
session_start();
include("includes/config.php");
include("includes/dbcon.php");

if(isset($_POST['submit'])){

//maintain session
$_SESSION['msg']='';

 $page_name=$_SESSION['curr_page_name']; 

if($page_name=='/coinera/index.php' || $page_name=='/coinera/'){
	$page_name='profile.php';
}


 function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
} 

$user_name=input_sanitize($_POST["username"]);
$password=input_sanitize($_POST["password"]);
$flag=1;

if($user_name=='' || $password==''){
$flag=0;
   $_SESSION['msg']='Username or Password cant be blank';
  header("Location:$page_name");
}

if($flag==1){
$query = mysql_query("SELECT * FROM `user_info` where BINARY user_name='".$user_name."' AND BINARY password='".$password."'");
	
if (mysql_num_rows($query) == 1){
$get_user_id=mysql_fetch_array($query);
     $_SESSION['user_name'] = $get_user_id['user_name'];
	 $_SESSION['user_id'] = $get_user_id['id'];
	 $_SESSION['msg']='Welcome '.$get_user_id['user_name'];
	 
header("Location:$page_name"); 
}

else{
    $_SESSION['msg']='Login Failed. Try again';
    header("Location:$page_name"); 
  }
 }
}
?>