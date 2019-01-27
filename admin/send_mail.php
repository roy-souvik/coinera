<?php
error_reporting(0);
ob_start();
date_default_timezone_set('Asia/Kolkata');
require("admin_utils.php");
if($_SESSION['admin_userid']==''){
	header('Location: index.php');
}
?>
<?php
disphtml("main();");
	
ob_end_flush();
function main()
{
?>
<link rel="stylesheet" href="css/default.css" type="text/css">
<table width="99%" align="center" border="0" cellpadding="5" cellspacing="1">
<input type="hidden" name="status" >
  <tr> 
      <td width="87%" align="center" class="ErrorText"><?=$GLOBALS['err_msg']?> </td>	
	  <td width="7%" align="right"><a href="javascript:document.frm_opts.submit();" title=" Refresh the page"><img border="0" src="images/icon_reload.gif"></a></td>
  </tr>
</table>

<?php
if(isset($_GET['seller_id'])){

$seller_id=$_GET['seller_id'];
$buyer_id=$_GET['buyer'];
$prod_id=$_GET['prod_id'];


		$sql = "SELECT user_name,email_id FROM `user_info` WHERE id=".$seller_id;		
		$rs  = mysql_query($sql);
		$rec = mysql_fetch_array($rs);
		
//GET PRODUCT INFORMATION
$product=mysql_fetch_array(mysql_query("SELECT title,images FROM `product_info` WHERE id=".$prod_id));

//GET BUYER INFORMATION		
//echo "SELECT * FROM `user_info` WHERE id=".$buyer_id	;
$buyer=mysql_fetch_array(mysql_query("SELECT * FROM `user_info` WHERE id=".$buyer_id));	
$buyer_name=$buyer['ship_first_name']." ".$buyer['ship_last_name']; 	
$buyer_address=$buyer['ship_address']."<br> City : ".$buyer['ship_city']."<br> State : ".$buyer['ship_state']."<br> Country:".$buyer['ship_country']."<br> Zip Code: ".$buyer['ship_zip_code']; 	 	 	 	
$buyer_phone=$buyer['ship_phone'];
}
?>
<style>
.validation_message{
background-color:lemonchiffon;
/* border:1px dashed orange;
text-align:center;
color: maroon;
font-weight: bold;
font-size: 13px;
padding: 5px; */
}
</style>
<!--- TinyMCE -->
<script type="text/javascript" src="../includes/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,,justifyleft,justifycenter,justifyright,justifyfull,|,undo,redo,|,code,cleanup,|,help",
		theme_advanced_buttons2: "",
		theme_advanced_buttons3: "",
		theme_advanced_buttons4: "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true
	});

</script>
<!-- /TinyMCE -->

  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="ThinTable">
  <tr>
    <td align="center"><table width="100%" align="center"  cellpadding="4" cellspacing="4" >
          <tr class="TDHEAD"> 
            <td colspan="3" align="left" style="padding-left:10px;"  class="text_main_header">Send mail to seller</td>
          </tr>
		  
		<tr>
			<td align="center"><table width="100%" align="center"  cellpadding="4" cellspacing="4" >
				<div id="mail_status" class="validation_message"></div>
			</td>
		</tr> 		  
          <tr>
			<td height="10" colspan="3"></td>		
		  </tr>
          
          <tr> 
            <td class="text_small" align="left">To :</td>
            <td class="text_small">:</td>
            <td align="left"><?=$rec['email_id']?></td>
			<input type="hidden" id="email_id" value="<?=$rec['email_id']?>">
			<input type="hidden" id="title" value="<?=$product['title']?>">
			<input type="hidden" id="image" value="<?=$product['images']?>">
			<input type="hidden" id="buyer_name" value="<?=$buyer_name?>">
			<input type="hidden" id="buyer_address" value="<?=$buyer_address?>">
			<input type="hidden" id="buyer_phone" value="<?=$buyer_phone?>">
			
			<input type="hidden" id="buyer_id" value="<?=$buyer_id?>">
			<input type="hidden" id="seller_id" value="<?=$seller_id?>">
			<input type="hidden" id="product_id" value="<?=$prod_id?>">
          </tr>
          
		  <tr> 
            <td class="text_small" align="left">Message </td>
            <td class="text_small">:</td>
            <td align="left">
			   <textarea id="message" class="message" name="message" rows="15" cols="80" style="width: 80%">
				</textarea>
			</td>
          </tr>
		  
			<tr><td class="point_txt" colspan="2">
				<input name="submit" type="submit" id="submit" class="" value="Send Mail"/></td> 
			</tr>
		
          <tr>
			<td height="10" colspan="3"></td>		
		  </tr>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>		  
<script>		  
$(document).ready(function() {

 	$('#submit').click(function() {
	
	  var seller_email=$('#email_id').val(); 
	  var message = tinyMCE.get('message').getContent();
 	  var title=$('#title').val();
	  var image=$('#image').val();
	  var buyer_name=$('#buyer_name').val();
	  var buyer_address=$('#buyer_address').val();
	  var buyer_phone=$('#buyer_phone').val();
	  
	  var buyer_id=$('#buyer_id').val();
	  var seller_id=$('#seller_id').val();
	  var product_id=$('#product_id').val();
	  
	  if(message!=''){	
	  
	  $('#mail_status').html('<center>Please Wait...</center>');
	  
		$.post('send_mail_ajax.php',{seller_email:seller_email,message:message,image:image,title:title,
									buyer_name:buyer_name,buyer_address:buyer_address,buyer_phone:buyer_phone,
									buyer_id:buyer_id,seller_id:seller_id,product_id:product_id},function(data){
	
			$('#mail_status').html(data);
		});
		
	  }
	  else{
	  
	     alert('message cannot be empty');
	  } 
	  
  });
}); 
</script>		  
           
   </table></td>
</tr>
<!-- </form> -->
<td class="point_txt">&nbsp; 
 <input name="button" type="button" class="inplogin" onClick="javascript:window.location='admin_product_confirmation.php';"  value="Back"> 
</td>
</table>
<?php
}//End of main()
?>