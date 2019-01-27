<?php
include("includes/image_upload_func.php");
include("header.php");
?>
<?php
if(isset($_SESSION['user_name']) && isset($_SESSION['user_id'])){
	header('Location:index.php');
}
?>

<script src="js/jquery-1.7.2.min.js"></script>
<?php
$GLOBALS['msg']='';
$GLOBALS['msg_user']='';
$GLOBALS['user_status_msg']='';
$GLOBALS['email_id_status']='';
if(isset($_POST['submit'])){

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

if((!filter_var($_POST['phone'], FILTER_SANITIZE_STRING)) || (!filter_var($_POST['zip_code'], FILTER_VALIDATE_INT))){
	$GLOBALS['msg'] = "Enter only 10 digits (max) integers in phone number,zip code and fax fields";
	$flag=0;
}

if((!filter_var($_POST['day'], FILTER_VALIDATE_INT)) || (!filter_var($_POST['year'], FILTER_VALIDATE_INT))){

$GLOBALS['msg'] = "Enter only integers in day & year fields";
$flag=0;
}

if(!filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL)){
	$GLOBALS['msg'] = "Enter a valid email id";
	$flag=0;
}

/* if(!filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL)){
	$GLOBALS['msg'] = "Enter a valid paypal email id";
	$flag=0;
} */

if($_SESSION['user_status']!=1){
	$GLOBALS['user_status_msg']='User name not available';
	$flag=0;
} 
if($_SESSION['email_id_status']!=1){
	$GLOBALS['email_id_status']='Sorry the email id is already in our records';
	$flag=0;
} 

if($flag==1){
	
	

/* 	
ship_first_name	= '".."',
ship_last_name 	= '".."',
ship_address	= '".."',
ship_state 	  	= '".."',
ship_country 	= '".."',
ship_zip_code 	= '".."',
ship_phone 		= '".."',
ship_fax	  	= '".."',
*/
/* 	paypal_email 	= '".input_sanitize($_POST['paypal_email'])."', */

 $date_of_birth =$_POST['day']."-".$_POST['month']."-".$_POST['year'];

 $activation_code = md5(uniqid(rand()));

$filename=upload_image(realpath('ProfileImage/normal/'),realpath('ProfileImage/thumbs/'));

$sql="INSERT INTO `temp_user_info`
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
			entry_date		= CURDATE(),
			activation_code = '".$activation_code."'";

		mysql_query($sql) or die(mysql_error()."Error in Upload"); 

	$GLOBALS['msg'] = "Information stored Successfully";
/* ============================================SENDING MAIL TO ADMIN [start]====================================================== */	

		$admin_mail=mysql_fetch_array(mysql_query("select admin_mail from admin_master where admin_id =1"));
		$fromEmail=$admin_mail['admin_mail'];
		
		$name=input_sanitize($_POST['first_name'])." ".input_sanitize($_POST['last_name']);
		$email=input_sanitize($_POST['email_id']);
		$phone=input_sanitize($_POST['phone']);
		$user_name=input_sanitize($_POST['user_name']);


	   $message="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
					<td>
					<div><div align='center' style='height:auto; width:450px;background:#FFFFFF; border:1px #19709D solid;'>
						<table width='100%' cellpadding='5px' cellspacing='0'>
							<tr>
								<td colspan='3'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:440px;'></td>
							</tr>
							<tr>
								<td width='30%' align='left' valign='top'>Name</td>
								<td align='left' width='1%' valign='top'>:</td>
								<td width='69%' align='left' valign='top'>".$name."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Email ID</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$email."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Phone</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$phone."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>User Name</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$user_name."</td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
						</table>
					</div></div>
					</td>
					<tr>
					</table>";
					
	   $to = $fromEmail;
	   $subject = "New User Registration Details";
	   $headers = 'From: '.$email. "\r\n";
	   $headers.= 'MIME-Version: 1.0' . "\r\n";
	   $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	   
	   if(mail($to, $subject, $message, $headers)){						
/* ============================================= SENDING MAIL TO USER [start] =====================================================*/	
		
		
		$link="http://arhamcreation.in/coinera/activation.php?activationkey=".$activation_code;
		
		$user_name=input_sanitize($_POST['user_name']);
		$password=input_sanitize($_POST['password']);
		/*$message2="<fieldset><table>
					<tr><td colspan='2'><h3>Registration Details for Coin Era</h3></td></tr>
					<tr><td>User Name</td><td>:</td><td>".$user_name."</td></tr>
					<tr><td>Password</td><td>:</td><td>".$password."</td></tr>
				  </table></fieldset>";*/
				  
		
	   $message2="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
					<td>
					<div><div align='center' style='height:auto; width:450px;background:#FFFFFF; border:1px #19709D solid;'>
						<table width='100%' cellpadding='5px' cellspacing='0'>
							<tr>
								<td colspan='3'><img src='http://arhamcreation.in/coinera/images/coin_mail_logo.jpg' style='width:440px;'></td>
							</tr>
							<tr>
								<td width='30%' align='left' valign='top'>User ID</td>
								<td align='left' width='1%' valign='top'>:</td>
								<td width='69%' align='left' valign='top'>".$user_name."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Password</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$password."</td>
							</tr>
							<tr>
								<td align='left' valign='top'>Email ID</td>
								<td align='left' valign='top'>:</td>
								<td align='left' valign='top'>".$email."</td>
							</tr>
							
							<tr>
								<td colspan='3'>Please click on the Url to activate your account \r\n <br />".$link."</td>
							</tr>
							<tr>
								<td colspan='3'>Thank You For Registering with us.<br/>Regards,<br><strong>Coin Era Team</strong></td>
							</tr>
							<tr>
								<td colspan='3'></td>
							</tr>
						</table>
					</div></div>
					</td>
					<tr>
					</table>";

	   $to_user = $email;
	   $subject_user = "Coin Era - New User Activation";
	   $headers2 = 'From: Coin Era <'.$fromEmail.'>' . "\r\n";
	   $headers2.= 'MIME-Version: 1.0' . "\r\n";
	   $headers2.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	   
	   	   if(mail($to_user, $subject_user, $message2, $headers2)){	
		   	$GLOBALS['msg_user']= "You are successfully Registered with us. <br> An Activation link has been sent to your Mail. Please click on that link to Activate your account.";
		   }
		   else{   
		   $GLOBALS['msg_user']= "Unable to send mail";
		   }
/* ============================================= SENDING MAIL TO USER [end] =====================================================*/				
	   }	   
	   else{	  
			$GLOBALS['msg_user']= "Unable to send mail to admin";
			echo "<script> alert('Message Not Sent');</script>"; 
	   }	   
/* ============================================SENDING MAIL TO ADMIN [end]====================================================== */

 }//end of if condition where flag=1
 
}//end of if condition
?>
<script type="text/javascript">
function formValidate(form,current_id)
		{	
 			document.getElementById("first_name_required").innerHTML = '';
			document.getElementById("last_name_required").innerHTML = '';
			document.getElementById("user_name_required").innerHTML = '';
			document.getElementById("password_required").innerHTML = '';
			document.getElementById("confirm_password_required").innerHTML = '';
			document.getElementById("email_required").innerHTML = '';
			document.getElementById("address_required").innerHTML = '';
			document.getElementById("city_required").innerHTML = '';
			document.getElementById("state_required").innerHTML = '';
			document.getElementById("country_required").innerHTML = '';
			document.getElementById("phone_required").innerHTML = '';
			document.getElementById("zip_code_required").innerHTML = '';
/* 			document.getElementById("paypal_email_required").innerHTML = ''; */
			document.getElementById("date_of_birth_required").innerHTML = '';
		
			var emailPattern =/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+([.-]?[a-zA-Z0-9]+)?([\.]{1}[a-zA-Z]{2,4}){1,4}$/;

			var flag = 1;
			
			if(!form.first_name.value){
				document.getElementById("first_name_required").innerHTML = "Please enter first name";
				flag = 0;
			}
			
			if(!form.last_name.value){
				document.getElementById("last_name_required").innerHTML = "Please enter last name";
				flag = 0;
			}
			
			if(!form.user_name.value){
				document.getElementById("user_name_required").innerHTML = "Please enter user name";
				flag = 0;
			}
			
		    if(!form.password.value){
				document.getElementById("password_required").innerHTML = "Please enter a password";
				flag = 0;
			}
			
		    if(!form.confirm_Password.value){
				document.getElementById("confirm_password_required").innerHTML = "Please confirm the password";
				flag = 0;
			}
			
			if(!form.email_id.value || !emailPattern.test(form.email_id.value))
			{
				document.getElementById("email_required").innerHTML = "Please Enter a valid email";
				flag = 0;
			}
			
			if(!form.address.value){
				document.getElementById("address_required").innerHTML = "Please enter address";
				flag = 0;
			}
			
			if(!form.city.value){
				document.getElementById("city_required").innerHTML = "Please enter name of the city";
				flag = 0;
			}
			
			if(!form.state.value){
				document.getElementById("state_required").innerHTML = "Please enter name of the state";
				flag = 0;
			}
			
			if(!form.country.value){
				document.getElementById("country_required").innerHTML = "Please select a country";
				flag = 0;
			}
			
			if(!form.phone.value)
			{
				document.getElementById("phone_required").innerHTML = "Please Enter a valid phone number";
				flag = 0;
			}
			
			if(!form.zip_code.value){
				document.getElementById("zip_code_required").innerHTML = "Please enter a zip code";
				flag = 0;
			}
			
			if((!form.day.value) || (!form.month.value) || (!form.year.value)){
				document.getElementById("date_of_birth_required").innerHTML = "Please check the date of birth";
				flag = 0;
			}
		    
/* 			if(!form.paypal_email.value || !emailPattern.test(form.paypal_email.value))
			{
				document.getElementById("paypal_email_required").innerHTML = "Please Enter a valid paypal email id";
				flag = 0;
			}	 */	
			
   if(flag == 0) {
	return false;
	} 
	else {
		return true;
	}
}

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57)){
		 alert("Only numbers allowed in this field");
            return false;
		 }
         return true;
      } 
</script>
 <div class="outerdiv_frame">
 <?php 
	if($GLOBALS['msg']!='' || $GLOBALS['msg_user']!='' || $GLOBALS['user_status_msg']!='' || $GLOBALS['email_id_status']!=''){
 ?>
 <center>
	<div class="validation_message">
		<?php echo $GLOBALS['msg']."<br/>".$GLOBALS['msg_user']."<br/>".$GLOBALS['user_status_msg']."<br>".$GLOBALS['email_id_status']; ?>
	</div>
 </center>
 <?php } ?>
  <form id="register_form" name="register" method="post" action="" enctype="multipart/form-data" onSubmit="return formValidate(this,'0');">
    <table class="register_table" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>First Name<font color="#ff0300"> *</font></td><td>:</td>
        <td><input type="text" id="first_name" name="first_name" />
			<!--<div id="first_name_required" class="js_alert"></div> -->
		</td>

        <td>Last Name<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="last_name" name="last_name" />
			<!--<div id="last_name_required" class="js_alert"></div>-->
		</td>
      </tr> 
      
      <tr class="register_col"><td colspan="3"><div id="first_name_required" class="js_alert"></div></td><td colspan="3"><div id="last_name_required" class="js_alert"></div></td></tr>
      
      <tr>
        <td>User Name<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="user_name" name="user_name" autocomplete="off"/>
		<!--<span id="username_status" class="js_alert"></span>-->
		<!--<div id="user_name_required" class="js_alert"></div>-->
		<script type="text/javascript" src="scripts/users.js"></script>
		
		</td>

        <td>Password<font color="#ff0300"> *</font></td><td>:</td><td><input type="password" title="Minimum Six Characters" id="password" class="password" name="password" autocomplete="off"/>
		<!--<div id="password_required" class="js_alert"></div>-->
		  <script type="text/javascript" src="scripts/password.js"></script>
		  <!--<span id="passstrength" class="js_alert"></span>-->
		</td>
		</tr>
        
        <tr class="register_col">
            <td colspan="3">
           		 <div id="user_name_required" class="js_alert" style="width: 145px; float: left;"></div>
           		 <div id="username_status" class="js_alert" style="float: right; padding: 0; color:#830B0B; height:21px;"></div>
            </td>
            <td colspan="3">
           		<div id="password_required" class="js_alert" style="width: 135px; float: left;font-size: 10px;"></div>
                <span id="passstrength" class="js_alert" style="float: right; padding: 0 8px 0 0; color:#830B0B; height:21px;"></span>
            </td>
        </tr>
      
      <tr>
        <td>Profile Image</td><td>:</td><td><input type="file" id="image" name="image" class="inp_file"></td>
        <td>Confirm Password<font color="#ff0300"> *</font></td><td>:</td><td>
		<input type="password" id="confirm_Password" name="confirm_password" autocomplete="off"/>
		<!--<div id="confirm_password_required" class="js_alert"></div>-->
		</td>
      </tr>
      
      <tr class="register_col"><td colspan="3"></td><td colspan="3"><div id="confirm_password_required" class="js_alert"></div></td></tr>
      
      <tr>
        <td>Email Id<font color="#ff0300"> *</font></td><td>:</td><td>
			<input type="text" id="email_id" name="email_id" />
		    <!--<span id="email_id_status" class="js_alert"></span>-->
			<!--<div id="email_required" class="js_alert"></div>-->
			<script type="text/javascript" src="scripts/email.js"></script>
		</td>
      
        <td>Date of Birth<font color="#ff0300"> *</font></td>
        <td>:</td>
        <td>
        	<input type="text" id="day" name="day" maxlength="2" onkeypress="return isNumberKey(event)" />
            
        	<select title="Select month" name="month" id="month">
					<option title="Select month" value="" selected="">Select month</option>
					<option title="January" value="1">January</option>
					<option title="February" value="2">February</option>
					<option title="March" value="3">March</option>
					<option title="April" value="4">April</option>
					<option title="May" value="5">May</option>
					<option title="June" value="6">June</option>
					<option title="July" value="7">July</option>
					<option title="August" value="8">August</option>
					<option title="September" value="9">September</option>
					<option title="October" value="10">October</option>
					<option title="November" value="11">November</option>
					<option title="December" value="12">December</option>
			</select>
            
            <input type="text" id="year" name="year" maxlength="4" onkeypress="return isNumberKey(event)" />
            <!--<div id="date_of_birth_required" class="js_alert"></div>-->
        </td>
      </tr>
      
      <tr class="register_col">
      <td colspan="3">     
          <div id="email_required" class="js_alert" style="width: 145px; float: left;"></div>
          <span id="email_id_status" class="js_alert" style="float: right; padding: 0; height:21px;"></span>
      </td>
      <td colspan="3"><div id="date_of_birth_required" class="js_alert"></div></td>
      </tr>
      
      <tr>
        <td>Address<font color="#ff0300"> *</font></td><td>:</td><td><textarea name="address" id="address" ></textarea>
		<!--<div id="address_required" class="js_alert"></div>--></td>

        <td>City<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="city" name="city" />
		<!--<div id="city_required" class="js_alert"></div>-->
		</td>
	  </tr>
      
      <tr class="register_col"><td colspan="3"><div id="address_required" class="js_alert"></div></td><td colspan="3"><div id="city_required" class="js_alert" style="margin-top: -10px"></div></td></tr>
      
      <tr>
        <td>State<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="state" name="state" />
		<!--<div id="state_required" class="js_alert"></div>-->
		</td>

        <td>Country<font color="#ff0300"> *</font></td><td>:</td>
		<td>                 
            <select name="country" id="country" placeholder="Country" >
             	<option value="">Select</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Ashmore and Cartier Islands">Ashmore and Cartier Islands</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Baker Island">Baker Island</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Bassas da India">Bassas da India</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bonaire">Bonaire</option>
                <option value="Bosnia-Herzegovina">Bosnia-Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Columbia">British Columbia</option>
                <option value="British Indian Ocean ">British Indian Ocean </option>
                <option value="British Virgin Islands">British Virgin Islands</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burma">Burma</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Canary Islands">Canary Islands</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Clipperton Island">Clipperton Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo Democratic Republic">Congo Democratic Republic</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Coral Sea Islands">Coral Sea Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote d-Ivoire">Cote d-Ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Curacao">Curacao</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equitorial Guinea">Equitorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Europa Island">Europa Island</option>
                <option value="Falkland Islands">Falkland Islands</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Gaza Strip">Gaza Strip</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Glorioso Islands">Glorioso Islands</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-Bissau">Guinea-Bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Holland">Holland</option>
                <option value="Holy See (Vatican City)">Holy See (Vatican City)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Howland Island">Howland Island</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option selected="selected" value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran">Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Ivory Coast">Ivory Coast</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Jan Mayen">Jan Mayen</option>
                <option value="Japan">Japan</option>
                <option value="Jarvis Island">Jarvis Island</option>
                <option value="Jersey">Jersey</option>
                <option value="Johnston Atoll">Johnston Atoll</option>
                <option value="Jordan">Jordan</option>
                <option value="Juan de Nova Island">Juan de Nova Island</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kingman Reef">Kingman Reef</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Laos">Laos</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libya">Libya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macau">Macau</option>
                <option value="Macedonia">Macedonia</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Man, Isle of">Man, Isle of</option>
                <option value="Manitoba">Manitoba</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia">Micronesia</option>
                <option value="Midway Islands">Midway Islands</option>
                <option value="Moldova">Moldova</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Navassa Island">Navassa Island</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Brunswick">New Brunswick</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Newfoundland">Newfoundland</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="North Korea">North Korea</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Northwest Territories">Northwest Territories</option>
                <option value="Norway">Norway</option>
                <option value="Nova Scotia">Nova Scotia</option>
                <option value="Oman">Oman</option>
                <option value="Ontario">Ontario</option>
                <option value="Pacific Ocean">Pacific Ocean</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palmyra Atoll">Palmyra Atoll</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paracel Islands">Paracel Islands</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn Islands">Pitcairn Islands</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Prince Edward Island">Prince Edward Island</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Quebec">Quebec</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saba">Saba</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saskatchewan">Saskatchewan</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Korea">South Korea</option>
                <option value="Spain">Spain</option>
                <option value="Spratly Islands">Spratly Islands</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="St. Eustatius">St. Eustatius</option>
                <option value="St. Kitts &amp;amp; Nevis">St. Kitts &amp;amp; Nevis</option>
                <option value="St. Lucia">St. Lucia</option>
                <option value="St. Maarten">St. Maarten</option>
                <option value="St. Vincent &amp;amp; Grenadines">St. Vincent &amp;amp; Grenadines</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard">Svalbard</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Tahiti">Tahiti</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Tasmania">Tasmania</option>
                <option value="Thailand">Thailand</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad &amp;amp; Tobago">Trinidad &amp;amp; Tobago</option>
                <option value="Tromelin Island">Tromelin Island</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="Uruguay">Uruguay</option>
                <option value="US Virgin Islands">US Virgin Islands</option>
                <option value="USA">USA</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Vatican">Vatican</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Virgin Islands">Virgin Islands</option>
                <option value="Wake Island">Wake Island</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="West Bank">West Bank</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Western Samoa">Western Samoa</option>
                <option value="Yemen">Yemen</option>
                <option value="Yugoslavia">Yugoslavia</option>
                <option value="Zambia">Zambia</option>
            	<option value="Zimbabwe">Zimbabwe</option>
			</select>
        <!--<div id="country_required" class="js_alert"></div>-->
		</td>
	  </tr>
      
      <tr class="register_col"><td colspan="3"><div id="state_required" class="js_alert"></div></td><td colspan="3"><div id="country_required" class="js_alert"></div></td></tr>
	  
	  <tr>
        <td>Zip Code<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="zip_code" name="zip_code" onkeypress="return isNumberKey(event)" />
		<!--<div id="zip_code_required" class="js_alert"></div>--></td>

     <!--  
	   <td>Paypal Email</td><td>:</td><td><input type="text" id="paypal_email" name="paypal_email" />
		<!--<div id="paypal_email_required" class="js_alert"></div>-->
	<!--	</td> -->
		
          <td rowspan="3">Remarks</td>
          <td width="2" rowspan="3">:</td>
          <td rowspan="3"><textarea name="remarks" id="remarks" style="height: 70px;"></textarea></td>
	  </tr>
      
      <tr class="register_col"><td colspan="3"><div id="zip_code_required" class="js_alert"></div></td><!--<td colspan="3"><div id="paypal_email_required" class="js_alert"></div></td>--></tr>
      
      <tr>
        <td>Phone<font color="#ff0300"> *</font></td><td>:</td><td><input type="text" id="phone" name="phone" onkeypress="return isNumberKey(event)" />
		<!--<div id="phone_required" class="js_alert"></div>-->
		</td>
      
        <!--<td>Remarks</td><td width="2">:</td><td><textarea name="remarks" id="remarks"></textarea></td>-->
	  </tr>
      
      <tr class="register_col"><td colspan="6"><div id="phone_required" class="js_alert"></div></td></tr>
      
      <tr>
        <td colspan="6" class="btn_in_td_r">
		  <input style="padding: 3px 5px;" type="submit" class="view_button" name="submit" value="SUBMIT" />
		  <input style="padding: 3px 5px; margin-right: 4px;" type="reset" class="view_button" name="reset" value="RESET" />
       	</td>
      </tr>
	  
    </table>
  </form>
</div>

<?php
include("footer.php");
?>