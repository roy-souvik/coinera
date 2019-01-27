<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");


if(isset($_POST['user_id'])){

 function input_sanitize($data){
	$data=strip_tags($data);
	$data=trim($data);
	$data=mysql_real_escape_string($data);
	return $data;
} 

	$user_id=$_POST['user_id'];
	
	$get_personal_address = mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$user_id));
	
	$sql="UPDATE `user_info`
	SET
		ship_first_name = '".input_sanitize($get_personal_address['first_name'])."',
		ship_last_name = '".input_sanitize($get_personal_address['last_name'])."',
		ship_address = '".input_sanitize($get_personal_address['address'])."',
		ship_city = '".input_sanitize($get_personal_address['city'])."',
		ship_zip_code = ".input_sanitize($get_personal_address['zip_code']).",
		ship_state = '".input_sanitize($get_personal_address['state'])."',
		ship_country = '".input_sanitize($get_personal_address['country'])."',
		ship_phone = ".input_sanitize($get_personal_address['phone'])."
		WHERE id=".$user_id;

	mysql_query($sql) or die(mysql_error()."Error in Upload");
	
	$get_shipping_details = mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$user_id));
?>
<span style="float:right;"><a class="menu_top2" title="Edit shipping details" href="shipping_edit.php"><img style="width:20px;" src="images/edit.png"></a></span>
			  <table>
				  <tr>
               		   <td><h4>Name : <span><?php echo $get_shipping_details['ship_first_name']." ".$get_shipping_details['ship_last_name'];?></span></h4></td>
                       <td><h4>Address : <span><?php echo $get_shipping_details['ship_address'];?></span></h4></td>
                  </tr>
				  <tr>
               		   <td><h4>City : <span><?php echo $get_shipping_details['ship_city'];?></span></h4></td>
                       <td><h4>Zip Code : <span><?php echo $get_shipping_details['ship_zip_code'];?></span></h4></td>
                  </tr>
				  <tr>
                 		 <td><h4>State : <span><?php echo $get_shipping_details['ship_state'];?></span></h4></td>
                         <td><h4>Country : <span><?php echo $get_shipping_details['ship_country'];?></span></h4></td>
                  </tr>
                  <tr>
                		  <td><h4>Phone : <span><?php echo $get_shipping_details['ship_phone'];?></span></h4></td>
                          <td><h4>Fax : <span><?php echo $get_shipping_details['ship_fax'];?></span></h4></td>
                  </tr>
			  </table>	
<?php
}
?>