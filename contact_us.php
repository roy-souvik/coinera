<?php include("header.php"); 

//error_reporting(E_ALL | E_STRICT);
?>

<div class="body_cont">
    	<div class="banner">
            <div class="banner_frame"><img src="images/main_banner.jpg" /></div>
        </div>
        <div class="auction_product">
        <img src="images/auction_product_bg.png" />
        CONTACT US
        </div>
 


<?php
if(isset($_POST['submit']) && $_POST['name']!=""){

$GLOBALS['msg']='';
$flag=1;

if((!filter_var($_POST['phone'], FILTER_VALIDATE_INT))){
	$GLOBALS['msg'] = "Enter only integers in phone number field";
	$flag=0;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$GLOBALS['msg'] = "Enter a valid email id";
	$flag=0;
}


if($flag==1){
function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
} 

		$name=input_sanitize($_POST["name"]);
		$email=input_sanitize($_POST["email"]);
		$phone=input_sanitize($_POST["phone"]);
		$comments=input_sanitize($_POST["message"]);

		$message ="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
					  <td>
					   <div>
						 <div align='center' style='height:auto; width:455px; background:#FFFFF0; border:1px #790000 solid;'>
						  <table cellpadding='0' cellspacing='5'>
							<tr>
								<th colspan='3' style='border-bottom:1px solid #790000;'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:445px;'></th>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
							<tr>
								<td width='15%' align='left' valign='top'>Name</td>
								<td width='2%' align='left' valign='top'>:</td>
								<td width='70%' align='left' valign='top'>".$name."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Email</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$email."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Phone No</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$phone."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Comments</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$comments."</td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
						</table>
					  </div>
					</div>
				  </td>
				</tr>
			  </table>";
		
	   $admin_mail_query=mysql_fetch_array(mysql_query("select * from admin_master where admin_id=1"));		
	   $to = $admin_mail_query['admin_mail'];
	   
	   $subject = "Message: from ".$name;
	   $headers = 'From: '.$email. "\r\n";
	   $headers.= 'MIME-Version: 1.0' . "\r\n";
	   $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	   
	   if(mail($to, $subject, $message, $headers)){
			
			$GLOBALS['msg']= "Your message has been sent";
			/*echo "<script> alert('Message Sent');</script>"; */
	   }
	   else{
			$GLOBALS['msg']= "Unable to send you message";
			/*echo "<script> alert('Message Not Sent');</script>"; */
	   }
   }//end of if condition where flag=1
}
?>
<script type="text/javascript">
  function formValidate(form,current_id)
		{	
			document.getElementById("name_required").innerHTML = '';
			document.getElementById("email_required").innerHTML = '';
			document.getElementById("phone_required").innerHTML = '';
			document.getElementById("message_required").innerHTML = '';
		
			var emailPattern =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)?([\.]{1}[a-zA-Z]{2,4}){1,4}$/;
			var flag = 1;
			
			if(!form.name.value){
				document.getElementById("name_required").innerHTML = "Please Enter a Name";
				flag = 0;
			}

			if(!form.email.value || !emailPattern.test(form.email.value))
			{
				document.getElementById("email_required").innerHTML = "Please Enter a valid email";
				flag = 0;
			}
			
			if(!form.phone.value)
			{
				document.getElementById("phone_required").innerHTML = "Please Enter a valid mobile number";
				flag = 0;
			}
			
			if(!form.message.value){
				document.getElementById("message_required").innerHTML = "Please Enter a message";
				flag = 0;
			}

			if(flag == 0) {
				return false;
			} else {
				return true;
			}
		}
	  
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57)){
		 document.getElementById("phone_required").innerHTML = 'Only numbers allowed in this field';
            return false;
		 }
         return true;
      }
</script>	
<div class="body_content">

  <div class="about">	
  
   <div class="info_holder">
   		<span class="c_heading">Coin Era</span>
		<br/>
		E-mail : info@coinera.in
        <br />
		Phone : +91 8961633937 
	</div>
	<table class="contact_table">
	<?php 
		if($GLOBALS['msg']!=''){
	?>
	<tr><td colspan="3"><div class="validation_message"><?php echo $GLOBALS['msg']; ?></div></td></tr>
 <?php } ?>
		<form action="" method="POST" onSubmit="return formValidate(this,'0');" name="contact_form">	
			<tr><td>Name</td><td>:</td><td><input type="text" name="name" /></td>
				<!--<td><div id="name_required" class="js_alert"></div></td>-->
			</tr>
            
            <tr><td colspan="3"><div id="name_required" class="js_alert"></div></td></tr>
          
			<tr><td>Email</td><td>:</td><td><input type="text" name="email" /></td>
				<!--<td><div id="email_required" class="js_alert"></div></td>-->
			</tr>
            
            <tr><td colspan="3"><div id="email_required" class="js_alert"></div></td></tr>

            <tr><td>Phone</td><td>:</td><td><input type="text" name="phone" onkeypress="return isNumberKey(event)" /></td>
				<!--<td><div id="phone_required" class="js_alert"></div></td>-->
			</tr>
            
            <tr><td colspan="3"><div id="phone_required" class="js_alert"></div></td></tr>
                    
            <tr><td>Message</td><td>:</td><td><textarea rows="5" style="height:150px;" name="message"></textarea></td>
				<!--<td><div id="message_required" class="js_alert"></div></td>-->
			</tr>
            
            <tr><td colspan="3"><div id="message_required" class="js_alert"></div></td></tr>
             
			
			<tr><td colspan="3" style="padding-right:0px;">
				<input type="submit" value="SUBMIT" name="submit" class="view_button" />
				<input style="margin-right: 5px;" type="reset" value="RESET" name="reset" class="view_button"/>
			</td></tr>
			          		  
       </form>
       </table>
  </div>  
</div>


</div>
   
<?php include("footer.php"); ?>