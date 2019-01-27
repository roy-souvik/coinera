<?php
include("header.php"); 
error_reporting(0);

if(isset($_SESSION['user_name'])){
	header('Location:index.php');
}

// This is displayed if all the fields are not filled in
$empty_fields_message = "<h2>Please go back and complete the form.</h2><h4>Click <a class=\"two\" href=\"javascript:history.go(-1)\">here</a> to go back</h4>";
// Convert to simple variables
$email_address = $_POST['email_address'];
?>
<style>
#container h2 {margin: 20px 20px 0;}
#container h4 {margin: 0 20px;}
</style>
<?php
if (!isset($_POST['email_address'])) 
{
/* ============= VIEW THE PASSWORD RESET BOX START ============ */
?>

<script language="JavaScript">
function check1()
{			var emailPattern =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)?([\.]{1}[a-zA-Z]{2,4}){1,4}$/;
			var flag = 1;	
			if(!frmedit.email_address.value){
				alert('Enter email address');
				flag = 0;
			} else {
				if(!emailPattern.test(frmedit.email_address.value))
				{
					alert('Enter a valid email address');
					flag = 0;
				}
			}

	if(flag == 0) {
				return false;
			} else {
				return true;
			}
}
</script>
<style>
#email_m{
	color:#F00;
	font-size:12px;	
}
</style>

<div class="single_log">
<!--<span style="font-size:18px; font-weight:bold;">Forgot Password</span>-->
<form name="frmedit" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return check1();">

<!--<label for="email_address">Email :</label>
	<input type="text" title="Please enter your email address" name="email_address" autocomplete="off" class="input"/>

   <div id="button_holder">
	   <input type="submit" value="Submit" class="view_button"/>
	   <input style="margin-right: 5px;" type="reset" value="Reset" class="view_button"/>
   </div>-->
   
   
   
   <table align="left" style="border-right:1px solid rgba(30, 30, 30, 0.3); padding-right:20px;">
           
                <tr><td style="font-size:18px; padding-bottom:20px;padding-top: 0;">Forgot Password</td></tr>
                <tr><td>Email :</td></tr>
                <tr><td><input type="text" title="Please enter your email address" name="email_address" autocomplete="off" class="single_log_inp"/></td></tr>
                <tr>
                    <td align="left" id="button_holder">
                    <input type="submit" value="Submit" class="cart_checkout_btn"/>
	  				<input style="margin-left: 5px;" type="reset" value="Reset" class="cart_checkout_btn"/>
                    </td>
                </tr>
    </table>
    <table align="right" style="text-align:center; margin-top:25px;">
           
                <tr ><td  style="font-size:18px;">New to Coin Era ?</td></tr>
                <tr ><td>Get started now. It's fast and easy!</td></tr>
                <tr ><td>
                <a class="crt_a_link" href="register.php"> Register</a>
                </td></tr>
    </table>

</form>
</div>


<?php
/* ============= VIEW THE PASSWORD RESET BOX END ============ */
}
elseif (empty($email_address)){
	echo $empty_fields_message;
}

else {
	$email_address = mysql_real_escape_string($email_address);
	$status = "OK";
	$msg="";
	if (!stristr($email_address,"@") OR !stristr($email_address,".")){
		$msg="<h2 style=\"text-align: center;\">Your email address is not in the correct format.</h2><h4 style=\"text-align: center;\">Click <a class=\"two\" href=\"javascript:history.go(-1)\">here</a> to go back</h4>";
	$status= "NOTOK";
}

echo "";
	if($status=="OK"){
	
		$query="SELECT id,email_id FROM `user_info` WHERE email_id = '".$email_address."'";
		$st=mysql_query($query);
		$recs=mysql_num_rows($st);
		$row=mysql_fetch_object($st);
		$em=$row->email_address;// email is stored to a variable
		$id=$row->id;
		
	  if ($recs == 0) 
		{
			echo "<h2 style=\"text-align: center;\">Sorry your address is not there in our database. Please try again.</h2><h4 style=\"text-align: center;\">Click <a class=\"two\" href=\"javascript:history.go(-1)\">here</a> to go back</h4>";
		exit;
		}


function makeRandomPassword(){
$num = rand(7,1000);
$pass = "CoiN@".$num;
return $pass;
}

$random_password = makeRandomPassword();

/* $db_password = md5($random_password); */

$db_password = $random_password;

$sql = mysql_query("UPDATE `user_info` SET password='".$db_password."' WHERE email_id='".$email_address."' AND id=".$id);

$subject = "Your New Password";
$message = "Hello, you have chosen to reset your password.<br/><br/>";

$admin_email_sql=mysql_fetch_array(mysql_query("select * from admin_master where admin_id=1"));
$admin_email=$admin_email_sql['admin_mail'];


$message.="<table width='100%' border='0'>
			  <tr>
				 <td>
					<div>
					   <div align='center' style='height:auto; width:455px; background:#FFFFF0; border:1px #790000 solid;'>
						<table cellspacing='5' cellpadding='0'>
							<tr>
								<th colspan='3' style='border-bottom:1px solid #790000;'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:445px;'></th>
							</tr>
							<tr>
								<td colspan='3'>&nbsp;</td>
							</tr>
							<tr>
								<td width='24%' align='left' valign='top'>New Password</td>
								<td width='4%' align='left' valign='top'>:</td>
								<td width='72%' align='left' valign='top'><strong>".$random_password."</strong></td>
							</tr>
							<tr>
								<td colspan='3'>Please Login to access your account Click on the below link \r\n <br /> http://coinera.in/</td>
							</tr>
							<tr>
								<td colspan='3'>&nbsp;</td>
							</tr>
							<tr>
								<td colspan='3'>Regards,<br><strong>Coin Era Team</strong></td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
						</table>
					</div>
				</div>
			 </td>
		   <tr>
	    </table>";
					

	   $headers = 'From: '.$admin_email. "\r\n";
	   $headers.= 'MIME-Version: 1.0' . "\r\n";
	   $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			
   
	   if(mail($email_address, $subject, $message, $headers)){
			echo "<script> alert('Your new password has been sent! Please check your email!');</script>"; 
			echo "<script> window.location = \"index.php\"; </script>";
	   }
	   else{
			echo "<script> alert('Message Not Sent');</script>"; 
	   }	

session_destroy();
}
else {
	echo $msg;
}

}
?>

<?php
	include("footer.php"); 
?>