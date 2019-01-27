<?php
include("header.php");

if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}
$GLOBALS['msg']='';
$GLOBALS['msg_user']='';
$GLOBALS['user_status_msg']='';

if(isset($_POST['update'])){

$flag=1;

 function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
} 
if(
   strlen(input_sanitize($_POST['ship_first_name']))==0 
|| strlen(input_sanitize($_POST['ship_last_name']))==0
|| strlen(input_sanitize($_POST['ship_zip_code']))==0
|| strlen(input_sanitize($_POST['ship_country']))==0
|| strlen(input_sanitize($_POST['ship_address']))==0
|| strlen(input_sanitize($_POST['ship_city']))==0
|| strlen(input_sanitize($_POST['ship_state']))==0
|| strlen(input_sanitize($_POST['ship_phone']))==0
  ){
	$GLOBALS['msg'] = "There are some error(s) in the form";
	$flag=0;
}

/* if((!filter_var($_POST['ship_phone'], FILTER_VALIDATE_INT)) || (!filter_var($_POST['ship_zip_code'], FILTER_VALIDATE_INT))
	||(!filter_var($_POST['ship_fax'], FILTER_VALIDATE_INT))){
	$GLOBALS['msg'] = "Enter only 10 digits (max) integers in phone number,zip code and fax fields";
	$flag=0;
} */

if($flag==1){

$sql="UPDATE `user_info`
	SET
		ship_first_name = '".input_sanitize($_POST['ship_first_name'])."',
		ship_last_name = '".input_sanitize($_POST['ship_last_name'])."',
		ship_address = '".input_sanitize($_POST['ship_address'])."',
		ship_city = '".input_sanitize($_POST['ship_city'])."',
		ship_zip_code = ".input_sanitize($_POST['ship_zip_code']).",
		ship_state = '".input_sanitize($_POST['ship_state'])."',
		ship_country = '".input_sanitize($_POST['ship_country'])."',
		ship_phone = ".input_sanitize($_POST['ship_phone']).",
		ship_fax = ".input_sanitize($_POST['ship_fax'])."
		WHERE id=".$_SESSION['user_id'];

	mysql_query($sql) or die(mysql_error()."Error in Upload");


	$GLOBALS['msg'] = "Information updated Successfully";
	
	
 }//end of if condition where flag=1 


}//end of if condition



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$user_id = $_SESSION['user_id'];

$user_details = mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$user_id));
$id=$user_details['id'];
$ship_first_name=$user_details['ship_first_name'];
$ship_last_name=$user_details['ship_last_name'];
$ship_address=$user_details['ship_address'];
$ship_city=$user_details['ship_city'];
$ship_zip_code=$user_details['ship_zip_code'];
$ship_state=$user_details['ship_state'];
$ship_country=$user_details['ship_country'];
$ship_phone=$user_details['ship_phone'];
$ship_fax=$user_details['ship_fax'];

?>
<script type="text/javascript">
 function formValidate(form,current_id){	
  		
			document.getElementById("ship_first_name_required").innerHTML = '';
			document.getElementById("ship_last_name_required").innerHTML = '';
			document.getElementById("ship_address_required").innerHTML = '';
			document.getElementById("ship_city_required").innerHTML = '';
			document.getElementById("ship_state_required").innerHTML = '';
			document.getElementById("ship_country_required").innerHTML = '';
			document.getElementById("ship_phone_required").innerHTML = '';
			document.getElementById("ship_zip_code_required").innerHTML = '';
			document.getElementById("ship_fax_required").innerHTML = '';
			var flag = 1;
			
			if(!form.ship_first_name.value){
				document.getElementById("ship_first_name_required").innerHTML = "Please enter first name";
				flag = 0;
			}
			
			if(!form.ship_last_name.value){
				document.getElementById("ship_last_name_required").innerHTML = "Please enter last name";
				flag = 0;
			}
			
			if(!form.ship_address.value){
				document.getElementById("ship_address_required").innerHTML = "Please enter address";
				flag = 0;
			}
			
			if(!form.ship_city.value){
				document.getElementById("ship_city_required").innerHTML = "Please enter name of the city";
				flag = 0;
			}
			
			if(!form.ship_state.value){
				document.getElementById("ship_state_required").innerHTML = "Please enter name of the state";
				flag = 0;
			}
			
			if(!form.ship_country.value){
				document.getElementById("ship_country_required").innerHTML = "Please select a country";
				flag = 0;
			}
			
			if(!form.ship_phone.value)
			{
				document.getElementById("ship_phone_required").innerHTML = "Please Enter a valid phone number";
				flag = 0;
			}
			
			if(!form.ship_zip_code.value){
				document.getElementById("ship_zip_code_required").innerHTML = "Please enter a zip code";
				flag = 0;
			}
			
			if(!form.ship_fax.value){
				document.getElementById("ship_fax_required").innerHTML = "Please enter a fax number";
				flag = 0;
			}
			
    		
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
<!--<fieldset style="float:left;margin-bottom:30px;"><legend><h2>Edit Shipping Details Here</h2></legend>-->

 <?php 
	if($GLOBALS['msg']!=''){
 ?>
 <center>
	<div class="validation_message">
		<?php echo $GLOBALS['msg']; ?>
	</div>
 </center>
 <?php } ?>
 
<form id="register_form" name="register" method="post" action="" onSubmit="return formValidate(this,'0');">
    <table class="register_table shipping_edit" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>First Name</td><td>:</td>
        <td><input type="text" id="ship_first_name" name="ship_first_name" value="<?php echo $ship_first_name;?>"/>
			<!--<div id="ship_first_name_required" class="js_alert"></div> -->
		</td>

        <td>Last Name</td><td>:</td><td><input type="text" id="ship_last_name" name="ship_last_name" value="<?php echo $ship_last_name;?>"/>
			<!--<div id="ship_last_name_required" class="js_alert"></div>-->
		</td>
      </tr> 
          
       <tr class="shipping_col">
           <td colspan="3"><div id="ship_first_name_required" class="js_alert"></div></td>
           <td colspan="3"><div id="ship_last_name_required" class="js_alert"></div></td>
       </tr>
     
      <tr>
        <td rowspan="3">Address</td><td rowspan="3">:</td><td rowspan="3"><textarea style="height: 70px;" name="ship_address" id="ship_address"><?php echo $ship_address;?></textarea>
		<!--<div id="ship_address_required" class="js_alert"></div>--></td>
        <td>City</td><td>:</td><td><input type="text" id="ship_city" name="ship_city" value="<?php echo $ship_city;?>"/>
		<!--<div id="ship_city_required" class="js_alert"></div>-->
		</td>
	  </tr>
      
      <tr class="shipping_col">
           <!--<td colspan="3"><div id="ship_address_required" class="js_alert"></div></td>-->
           <td colspan="3" class="shipping_state"><div id="ship_city_required" class="js_alert"></div></td>
       </tr>
      
      <tr>
       	 <td class="shipping_state">State</td><td>:</td><td><input type="text" id="ship_state" name="ship_state" value="<?php echo $ship_state;?>"/>
			<!--<div id="ship_state_required" class="js_alert"></div>-->
		 </td>
      </tr>
      
      <tr class="shipping_col">
           <td colspan="3"><div id="ship_address_required" class="js_alert"></div></td>
           <td colspan="3"><div id="ship_state_required" class="js_alert"></div></td>
       </tr>
      
      <tr>

        <td>Country</td><td>:</td>
		<td>                 
            <select name="ship_country" id="ship_country" placeholder="Country" >
             	<option value="<?=$ship_country?>"<?=($ship_country==$ship_country)?'selected="selected"':''?>><?=$ship_country?></option>
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
                <option value="India">India</option>
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
        <!--<div id="ship_country_required" class="js_alert"></div>-->
		</td>
        <td>Zip Code</td><td>:</td><td><input type="text" id="ship_zip_code" value="<?php echo $ship_zip_code;?>" name="ship_zip_code" onkeypress="return isNumberKey(event)"/>
		<!--<div id="ship_zip_code_required" class="js_alert"></div>--></td>
	  </tr>
      
      <tr class="shipping_col">
           <td colspan="3"><div id="ship_country_required" class="js_alert"></div></td>
           <td colspan="3"><div id="ship_zip_code_required" class="js_alert"></div></td>
       </tr>
	  
      
      <tr>
        <td>Phone</td><td>:</td><td><input type="text" id="ship_phone" value="<?php echo $ship_phone;?>" name="ship_phone" onkeypress="return isNumberKey(event)"/>
		<!--<div id="ship_phone_required" class="js_alert"></div>-->
		</td>
		
		<td>Fax</td><td>:</td><td><input type="text" id="ship_fax" value="<?php echo $ship_fax;?>" name="ship_fax" onkeypress="return isNumberKey(event)"/>
		<!--<div id="ship_fax_required" class="js_alert"></div>-->
		</td>
    </tr>
    
    <tr class="shipping_col">
           <td colspan="3"><div id="ship_phone_required" class="js_alert"></div></td>
           <td colspan="3"><div id="ship_fax_required" class="js_alert"></div></td>
     </tr>
     
     
     <!--<tr>
    <td rowspan="3">k</td>
    <td rowspan="3">&nbsp;</td>
    <td rowspan="3">&nbsp;</td>
    <td>1</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">0</td>
  </tr>
  <tr>
    <td>2</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">l</td>
    <td colspan="3">0</td>
  </tr>-->
      
      <tr>
        <td colspan="6" class="view_btn_frame">
		  <input type="submit" class="view_button" name="update" value="UPDATE" />
		  <input type="reset" class="view_button" name="reset" value="RESET" style="margin-right: 5px;" />
       	</td>
      </tr>
	  
    </table>
  </form>
<!--</fieldset>-->
<div class="back_link"><a href="profile.php">BACK</a></div>
</div>
<?php
include("footer.php");
?>