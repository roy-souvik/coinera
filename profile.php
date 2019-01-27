<?php
include("header.php");

if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}

$user_id = $_SESSION['user_id'];
$GLOBALS['user_status_message']='';
?>

<link rel="stylesheet" type="text/css" href="css/ui/jquery-ui-1.8.21.custom.css"/>

<style>
.notifications{
    background-color: #FFF;
    border-radius: 5px 5px 5px 5px;
    min-height: 22px;
	max-height: 322px;
    left: 50%;
    margin-left: -274px;
    margin-top: -100px;
    overflow-y: scroll;
    padding: 8px;
    position: absolute;
    top: 60%;
    width: 648px;
    z-index: 1000;
	border:2px solid #777;
	box-shadow: 0 1px 1px 0 #686868;
}

.notice_table {
	margin:0px;padding:0px;
	width:100%;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:5px;
	-webkit-border-bottom-left-radius:5px;
	border-bottom-left-radius:5px;
	
	-moz-border-radius-bottomright:5px;
	-webkit-border-bottom-right-radius:5px;
	border-bottom-right-radius:5px;
	
	-moz-border-radius-topright:5px;
	-webkit-border-top-right-radius:5px;
	border-top-right-radius:5px;
	
	-moz-border-radius-topleft:5px;
	-webkit-border-top-left-radius:5px;
	border-top-left-radius:5px;
}.notice_table table{
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.notice_table tr:last-child td:last-child {
	-moz-border-radius-bottomright:5px;
	-webkit-border-bottom-right-radius:5px;
	border-bottom-right-radius:5px;
}
.notice_table table tr:first-child td:first-child {
	-moz-border-radius-topleft:5px;
	-webkit-border-top-left-radius:5px;
	border-top-left-radius:5px;
}
.notice_table table tr:first-child td:last-child {
	-moz-border-radius-topright:5px;
	-webkit-border-top-right-radius:5px;
	border-top-right-radius:5px;
}.notice_table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:5px;
	-webkit-border-bottom-left-radius:5px;
	border-bottom-left-radius:5px;
}.notice_table tr:hover td{
	background-color:#ffffff;
		

}
.notice_table td{
	vertical-align:middle;
	
	background-color:#e0dbd7;

	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:center;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.notice_table tr:last-child td{
	border-width:0px 1px 0px 0px;
}.notice_table tr td:last-child{
	border-width:0px 0px 1px 0px;
}.notice_table tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.notice_table tr:first-child td{
		background:-o-linear-gradient(bottom, #999189 5%, #e0d1c3 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #999189), color-stop(1, #e0d1c3) );
	background:-moz-linear-gradient( center top, #999189 5%, #e0d1c3 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#999189", endColorstr="#e0d1c3");	background: -o-linear-gradient(top,#999189,e0d1c3);

	background-color:#999189;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:13px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.notice_table tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #999189 5%, #e0d1c3 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #999189), color-stop(1, #e0d1c3) );
	background:-moz-linear-gradient( center top, #999189 5%, #e0d1c3 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#999189", endColorstr="#e0d1c3");	background: -o-linear-gradient(top,#999189,e0d1c3);

	background-color:#999189;
}
.notice_table tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.notice_table tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
</style>
<?php
$user_details = mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$user_id));
$id=$user_details['id'];
$first_name=$user_details['first_name'];
$last_name=$user_details['last_name'];
$user_name=$user_details['user_name'];
$email_id=$user_details['email_id'];
/*$date_of_birth=$user_details['date_of_birth'];*/
$orderdate = explode('-', $user_details['date_of_birth']);
$month = $orderdate[1];
$day   = $orderdate[2];
$year  = $orderdate[0];

$address=$user_details['address'];
$city=$user_details['city'];
$zip_code=$user_details['zip_code'];
$state=$user_details['state'];
$country=$user_details['country'];
$phone=$user_details['phone'];
$image=$user_details['image'];
$email_id=$user_details['email_id'];
$paypal_email=$user_details['paypal_email'];
$user_status=$user_details['status'];

$date_of_birth = $day."-".$month."-".$year;

if($user_status=='N'){
	$GLOBALS['user_status_message']='Your account is not activated by the admin <br> 
									You can contact admin by <a target="_blank" href="contact_us.php">clicking here</a>';
}

if($user_status=='N'&& $GLOBALS['user_status_message']!=''){
?>	
 <center style="margin-bottom:20px;">
	<div class="validation_message">
		<?php echo $GLOBALS['user_status_message']; ?>
	</div>
 </center>
<?php
} // IF USER IS NOT ACTIVE THEN THIS MESSAGE WILL BE DISPALYED
?>

<div id="image" class="profile_image">
<table>
<tr><td>
	<img src="ProfileImage/thumbs/<?php echo $image;?>"></td></tr>
<tr><td><center><?php echo $first_name." ".$last_name;?></center></td></tr>
</table>
</div>

<!-- ================================= NOTIFICATION AREA [START]================================================= -->
<?php
$NOTICE_SQL=mysql_query("SELECT * FROM notification WHERE seller_id=".$_SESSION['user_id']);
if(mysql_num_rows($NOTICE_SQL)>0) {
?>
<img style="position:absolute;cursor:pointer;" class="notice" src="images/notice2.png"/>
<? } ?>
<div class="notifications">
<table class="notice_table">
<img src="images/close.png" style="cursor:pointer;float:right;margin-bottom:10px;" title="close" class="close_notification"/>
<?php
if(mysql_num_rows($NOTICE_SQL)>0) {
?>
<center><b style="font-size:14px;">Notifications</b></center>
<tr><td>Buyer's Username</td><td>Product Title</td><td>Image</td><td>Message</td><td>Expires on</td></tr>
<?php
while($row=mysql_fetch_array($NOTICE_SQL)){
//PRODUCT INFO
$PRODUCT_INFO=mysql_fetch_array(mysql_query("SELECT title,images FROM product_info WHERE id=".$row['product_id']));
//BUYER INFO
$BUYER_INFO=mysql_fetch_array(mysql_query("SELECT user_name FROM user_info WHERE id=".$row['buyer_id']));
//EXPIRE DATE
$EXPIRE_DATE=mysql_fetch_array(mysql_query("SELECT expire_date FROM product_status WHERE product_id=".$row['product_id']));
$orderdate = explode('-', $EXPIRE_DATE['expire_date']);
$expire_date=$orderdate[2]."-".$orderdate[1]."-".$orderdate[0];
?>
<tr>
	<td><?=$BUYER_INFO['user_name']?></td>
	<td><?=$PRODUCT_INFO['title']?></td>
	<td><img width="80" src="ProductImage/thumbs/<?=$PRODUCT_INFO['images']?>"></td>
	<td><?=$row['admin_msg']?></td>
	<td><?=$expire_date?></td>
</tr>
<?php
}
?>
<tr><td colspan="5"><b style="font-size:12px;">Please check your mail for details</b></td></tr>
<?php
}

else{
	echo"<center><h3>You have currently no notifications.</h3></center>";
}
?>
</table>
</div>

<script>
$('.notifications').hide();

$('.notice').click(function() {

$('.notice').attr('src','images/notice.png');
	$('.notifications').fadeIn('normal');
						
	$('#informaion_holder').css('opacity','0.2').$('.notifications').css('opacity','1');
});


 $('.close_notification').click(function() {
	$('.notifications').fadeOut('slow');
	$('.notice').attr('src','images/notice2.png');
	$('#informaion_holder').css('opacity','1');
}); 
</script>
<!-- ================================= NOTIFICATION AREA [END]================================================= -->
<div id="informaion_holder">
			<h3><a href="#" style="color:#444;font-weight:bold;">Personal Details</a></h3>
			  <div>
			  <span style="float:right;"><a class="menu_top" title="Edit personal details" href="personal_edit.php"><img style="width:20px;" src="images/edit.png"></a></span>
			   <table>
				<tr>
					<td><h4>Name : <span><?php echo $first_name." ".$last_name;?></span></h4></td>
					<td><h4>User Name : <span><?php echo $user_name;?></span></h4></td>
				</tr>
				
				<tr>
					<td><h4>Email id : <span><?php echo $email_id;?></span></h4></td>
					<td><h4>Date of birth : <span><?php echo $date_of_birth;?></span></h4></td>
				</tr>
				
				<tr>
					<td><h4>Address : <span><?php echo $address;?></span></h4></td>
					<td><h4>City : <span><?php echo $city;?></span></h4></td>
				</tr>
				
				<tr>
					<td><h4>Zip Code : <span><?php echo $zip_code;?></span></h4></td>
					<td><h4>State : <span><?php echo $state;?></span></h4></td>
				</tr>
				
				<tr>
					<td><h4>Country : <span><?php echo $country;?></span></h4></td>
					<td><h4>Phone : <span><?php echo $phone;?></span></h4></td>
				</tr>
			</table>	
			  </div>
			  
			<h3><a href="#" style="color:#444;font-weight:bold;">Shipping Details</a></h3>
			<div id="ship">
			  <input type="hidden" id="curr_user_id" value="<?=$user_id?>"  >
		<?php
			if($user_details['ship_first_name']!='' || $user_details['ship_address']!=''){	
		?>	
			  <span style="float:right;"><a class="menu_top2" title="Edit shipping details" href="shipping_edit.php"><img style="width:20px;" src="images/edit.png"></a></span>
		<?php
		} else {
		?>	
		<span style="float:right;">Same as Personal <input type="checkbox" name="same_as_personal" id="same_as_personal"></span>
		<script>
			$('#same_as_personal').click(function() {
			 if (this.checked ) {
				
				var user_id = $('#curr_user_id').val();
				
				$('#ship').html('<center><img src="images/loader.gif" style="border-radius:18px;"></center>');
 

			$.post('ajax_pages/get_same_address.php',{user_id:user_id},function(data){
	
				$('#ship').hide().fadeIn('normal').html(data);

			});  				
		   }			
		});
		</script>
		<?php } ?>

			  <table>
				  <tr>
               		   <td><h4>Name : <span><?php echo $user_details['ship_first_name']." ".$user_details['ship_last_name'];?></span></h4></td>
                       <td><h4>Address : <span><?php echo $user_details['ship_address'];?></span></h4></td>
                  </tr>
				  <tr>
               		   <td><h4>City : <span><?php echo $user_details['ship_city'];?></span></h4></td>
                       <td><h4>Zip Code : <span><?php echo $user_details['ship_zip_code'];?></span></h4></td>
                  </tr>
				  <tr>
                 		 <td><h4>State : <span><?php echo $user_details['ship_state'];?></span></h4></td>
                         <td><h4>Country : <span><?php echo $user_details['ship_country'];?></span></h4></td>
                  </tr>
                  <tr>
                		  <td><h4>Phone : <span><?php echo $user_details['ship_phone'];?></span></h4></td>
                          <td><h4>Fax : <span><?php echo $user_details['ship_fax'];?></span></h4></td>
                  </tr>
			  </table>	
     </div>
</div>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
<script>
$('#informaion_holder').accordion({ });
</script>

<br clear="all">
<hr class="coin" />
<?php 
	if($user_status=='Y' && $GLOBALS['user_status']!=''){

/* =========================================================================================================================== */
//echo "SELECT `product_id` FROM `seller_info` WHERE `user_id`=".$user_id;
/* $seller=mysql_query("SELECT `product_id` FROM `seller_info` WHERE `user_id`=".$user_id); */
	$seller=mysql_query("SELECT `id` FROM `product_info` WHERE `user_id`=".$user_id);
	$count_prod=mysql_num_rows($seller);
/* =========================================================================================================================== */
?>

<div id="selling_bidding">

<h3><a href="#" style="color:#444;font-weight:bold;">Selling Details</a></h3>
	  <div>
<?php
  $latest_products_query=mysql_query("SELECT id,images,title,bid_price,direct_price FROM `product_info` WHERE user_id=".$user_id." ORDER BY id DESC LIMIT 0,5");
?>
	    <h4 style="padding-left: 3px;">Latest added products:</h4>
		<table><tr>
		<?php
			while($latest_products=mysql_fetch_array($latest_products_query)){
		?>
			<td class="latest_add_pro">
			   <table>
				  <tr><td><img src="ProductImage/thumbs/<?php echo $latest_products['images'];?>"></td></tr>
				  <tr><td align="center"><b><?php echo substr($latest_products['title'],0,12)."..."; ?></b></td></tr>
		<?php
					if($latest_products['bid_price']!=0) {
		?>		
				  <tr><td align="center"><b>Bid price: Rs. </b><?php echo round($latest_products['bid_price'],2); ?></td></tr>
		<?php
				}
				else{
		?>	
				<tr><td align="center"><b>Direct price: Rs. </b><?php echo round($latest_products['direct_price'],2); ?></td></tr>
		<?php } ?>
			   </table>	
			</td>
		<?php } ?>
		</tr></table>
	  <hr/>	
			  <table class="total_pro_count">
				  <tr><td>
                      <span class="profile_bg" style="margin-right: 10px;">Total products count : <?php echo $count_prod;?></span>
                      <a style="margin-right: 10px;" href="personal_product_gallery.php">My products</a>
                      <a style="margin-right: 10px;" href="add_products.php">Add product</a>
                      <?php
					  if(mysql_num_rows($NOTICE_SQL)>0) {
					  ?>
					  <a href="set_product_status.php">Set product status</a>
                      <?php
					  }
					  ?>
                   </td></tr>
			  </table>	  
     </div>
<h3><a href="#" style="color:#444;font-weight:bold;">Bidding Details</a></h3>
	  <div>
<?php
  $latest_bids_query=mysql_query("SELECT id,product_id FROM `bid_info` WHERE user_id=".$user_id." 
     							  AND bid_price!=0 ORDER BY id DESC LIMIT 0,5");		  
?>	  
	  	    <h4 style="display: inline;padding-left: 3px;">Latest bids : </h4>
		<table><tr>
    <?php
		if(mysql_num_rows($latest_bids_query)==0) { 
			echo "<span>None</span>";
		}
		
		while($latest_bid=mysql_fetch_array($latest_bids_query)){
    ?>
			<td class="latest_add_pro">
<?php   
 $get_product_sql=mysql_query("SELECT id,images,title,bid_price FROM `product_info` WHERE id=".$latest_bid['product_id']." 
						    ORDER BY id DESC LIMIT 0,5");	 		
   //AND status='Y'
	//if(mysql_num_rows($get_product_sql)>0)	{	
		
			$get_product=mysql_fetch_array($get_product_sql);
?>
				<table>
					<tr><td><img src="ProductImage/thumbs/<?php echo $get_product['images'];?>"></td></tr>
					<tr><td align="center"><b><?php echo substr($get_product['title'],0,12)."...";?></b></td></tr>
					<tr><td><b>Price : Rs. </b><span><?php echo $get_product['bid_price'];?></span></td></tr>
<?php   
 $get_bid_price=mysql_fetch_array(mysql_query("SELECT final_bid_price FROM `bid_info` WHERE product_id=".$latest_bid['product_id']." 
						   AND user_id=".$user_id));	 		
?>					
					<tr><td><b>Bid Price : Rs. </b><span><?php echo round($get_bid_price['final_bid_price'],2);?></span></td></tr>
				</table>
			</td>
	<?php 
	   /* } 
		else { echo "<h3>No active bids</h3>"; } */
		} 
	?>
		</tr></table>
<hr/>		
			  <table>
<?php $bidder=mysql_num_rows(mysql_query("SELECT `product_id` FROM `bid_info` WHERE `user_id`=".$user_id));	 ?>			  
				  <tr>
					  <td>
						  <span class="profile_bg" style="margin-right: 13px;">Total bid count : <?php echo $bidder;?></span>
						  <a style="margin-right: 13px;" href="product_gallery.php">Bid for a product</a>
						  <a style="margin-right: 13px;" href="my_bids.php">My bids</a>
<?php
	$ordr_status=mysql_num_rows(mysql_query("SELECT * FROM `product_status` WHERE order_no!='' and `winner_id`=".$user_id));
						  if($ordr_status!=0){ ?>
						  <a style="margin-right: 13px;" href="my_orders.php">My Orders</a>
                          <?php } 
						  $won_status=mysql_num_rows(mysql_query("SELECT * FROM `product_status` WHERE `winner_id`=".$user_id));
						  if($won_status!=0){
						  ?>
						  <a href="won_products.php">Products Won</a>
                          <?php
						  }
						  ?>
					  </td>
			      </tr>
			  </table>	  
     </div> 
 
</div><script>
$('#selling_bidding').accordion({ heightStyle: "content" });
</script>
<?php
} // End of IF statement for checking that the user is active or not
?>

<?php
include("footer.php");
?>