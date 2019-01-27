<?php error_reporting(0);?>

<?php include("header.php"); ?>
<style type"text/css">
.bid_amount {
	padding-left:17px !important;
	border: 1px solid #999999 !important;
	border-radius: 6px;
	padding: 7px;
	margin: 7px 0;
	width: 310px;
	font-size: 14px;
	color: #555;
	-webkit-box-shadow: 0px 0px 4px #aaa !important;
	-moz-box-shadow: 0px 0px 4px #aaa !important;
	box-shadow: 0px 0px 4px #aaa !important;
	font-weight: bold;
	background:url(images/dollar.png) no-repeat;
	background-position:0% 44%;
}
.final_amount {
	padding-left:17px !important;
	border: 1px solid #999999 !important;
	border-radius: 6px;
	padding: 7px;
	margin: 7px 0;
	width: 310px;
	font-size: 14px;
	color: #555;
	-webkit-box-shadow: 0px 0px 4px #aaa !important;
	-moz-box-shadow: 0px 0px 4px #aaa !important;
	box-shadow: 0px 0px 4px #aaa !important;
	font-weight: bold;
	background:url(images/dollar.png) no-repeat !important;
	background-position:0% 44% !important;
}
</style>

<div class="outerdiv_frame product_details" style="margin-top:20px;">
<?php 
 $product_id=$_REQUEST['product_id'];
 $flag=$_REQUEST['flag'];
 $sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y' AND id=".$product_id);
 $product=mysql_fetch_array($sql);
 
 $row=mysql_num_rows($sql);
 
  if($row > 0){
	  if($flag==1){
		  $price=$product['bid_price']; 
		  $url='#';
		  $text="Bid";
		  }else if($flag==2){
			  $price=$product['direct_price'];
			  
			  if(!isset($_SESSION['user_name'])){
						$url='single_login.php';
						$_SESSION['login_page_url'] = $_SERVER["REQUEST_URI"];
					}else{
						$url='cart.php?id='.$product['id'].'&action=add';
					}
			  $text="Add to Cart";
			  }
			 // echo "SELECT id,user_name FROM user_info WHERE id=".$product['user_id']." AND status='Y'";
$sql_u_name=mysql_fetch_array(mysql_query("SELECT id,user_name FROM user_info WHERE id=".$product['user_id']." AND status='Y'"));
	  ?>
      <div class="pdt_det_cont">
            <h6 style="color:#744D39; font-size:12px; font-style:italic;">Posted by <?=$sql_u_name['user_name']?></h6>
            <h4 style="font-size:22px;"><?=$product['title']?><hr style="height: 1px;" /></h4>
            
            <div class="pdt_det_cont_d"><?=$product['description']?></div>
            
            <h4 style="font-size:16px;">Regular Price: <font color="#ff0300">Rs. <?=$price?></font></h4>            
      </div>
<!-- -----------------------start-------------------------- -->

<div id="content" style="float: right;width:300px;">
    <div class="zoomsDiv">
    <center>
        <a href="ProductImage/normal/<?=$product['images']?>" class="jqzoom" rel='gal1'  title="<?=$product['title']?>">
            <img src="ProductImage/thumbs/<?=$product['images']?>"  title="<?=$product['title']?>">
        </a>
    </center>
    </div>
	<br/>
 <div class="zooms_d_thumb">
 	<center>
	<ul id="thumblist">
	
		<li>
			<a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: './ProductImage/thumbs/<?=$product['images']?>',largeimage: './ProductImage/normal/<?=$product['images']?>'}">
				<img src='ProductImage/thumbs/<?=$product['images']?>'>
			</a>
		</li>

	<?php if($product['image2']!=''){ ?>	
		<li class="extra">
			<a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: './ProductImage/thumbs/<?=$product['image2']?>',largeimage: './ProductImage/normal/<?=$product['image2']?>'}">
				<img src='ProductImage/thumbs/<?=$product['image2']?>'>
			</a>
		</li>
	<?php } 
		if($product['image3']!=''){
	?>		
		<li>
			<a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: './ProductImage/thumbs/<?=$product['image3']?>',largeimage: './ProductImage/normal/<?=$product['image3']?>'}">
				<img src='ProductImage/thumbs/<?=$product['image3']?>'>
			</a>
		</li>
	<?php } ?>	

	</ul>
	</center>
	</div>
</div>
<!-- -----------------------end-------------------------- -->
      <?php if($flag==2 && $product['user_id']!=$_SESSION['user_id']){ ?>
            <div class="show_bids_details"><a href="<?=$url?>"><?=$text?> </a></div>
      <?php } ?>
            
      
	  <?php
  }else{
		echo "<span style='color:red;'>Opps! Sorry No Product Found.</span>";
			//$_SESSION['seller_id']=$product['user_id'];
		}
		
	//echo $_SESSION['seller_id']	;
?>

<!--=================================================================================================================-->
<?php
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
	$sql_check_for_s_type=mysql_query("SELECT user_id,bid_price,direct_price FROM product_info WHERE bid_status='Y' AND status='Y' AND id=".$product_id);
	$result_of_s_type=mysql_fetch_array($sql_check_for_s_type);
	if($result_of_s_type['bid_price']!=0 && $result_of_s_type['user_id']!=$_SESSION['user_id']){
		$sql_bid=mysql_query("select * from bid_info where user_id=".$_SESSION['user_id']." and product_id=".$product_id);
		$bid_sql=mysql_fetch_array($sql_bid);
		$bid_count=mysql_num_rows($sql_bid);
		if($bid_count<1){
		?>
			<div class="show_bid_details"><a style="text-decoration:underlined;cursor:pointer;">Bid for this Product</a></div>
		<?php
		}
	}
}else{ 
	if($flag==1){ ?>
	<div class="show_bids_details"><a style="text-decoration:underlined;cursor:pointer;" onclick="return confirm('Please Login to Bid for this Project');" href="single_login.php">
    <?php	$_SESSION['login_page_url'] = $_SERVER["REQUEST_URI"];?>
    	Bid for this Product
    </a></div>
<?php
	}
}
?>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {
		$("a#fancybox").fancybox({
			'type'				: 'iframe'
			});
		});
</script>
<script>
function formValidate(form,current_id,org_value)
{	
	document.getElementById("price_alert").innerHTML = '';
	//var textarea = tinyMCE.get('description').getContent();
		
	
	var flag = 1;
	if(!form.bid_amount.value){
		var price_alert = "Please Enter Bid price";
		document.getElementById('price_alert').innerHTML = price_alert;
		flag = 0;
	}
	else{
		if(form.bid_amount.value<org_value){
			document.getElementById('price_alert').innerHTML = "Bid Price should not be less than the Regular Price (Rs. "+org_value+")";
			flag = 0;
		}
	}
	/*if((textarea=="") || (textarea==null)){
		document.getElementById("description_alert").innerHTML = "Please Enter Bid's Description";
		flag = 0;
	}*/
	if(flag == 0) {
		return false;
	} else {
		return true;
	}
}

function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode <46 || charCode > 46) && (charCode < 48 || charCode > 57)){
		 alert("Please Enter only numbers and '.' in the field !!!");
            return false;
		 }
         return true;
      } 
	  
	  
function check_price(c_value,o_value)
{
	if(c_value<o_value){
		document.getElementById('price_alert').innerHTML = "Bid Price should not be less than the Regular Price (Rs. "+o_value+")";
		return false;
	}
	else{
		document.getElementById('price_alert').innerHTML = "";
	}
	return true;
} 	
	  
	  
	  
$(document).ready(function() {

	$('.bid_details').hide();
	
	$('.show_bid_details').click(function() {
	
		$('.bid_details').fadeToggle('normal');	
		
	});
	
$('.bid_amount').keyup(function() {

var bid_value=$('.bid_amount').val();

bid_value=parseFloat(bid_value);

	final_amnt=bid_value*2/100;
	final_amount=final_amnt+bid_value;
	var newnumber = new Number(final_amount+'').toFixed(parseInt(2));
	
	$('.final_amount').val(newnumber);
	
});


});

</script>

<!-- TinyMCE -->
<script type="text/javascript" src="includes/tinymce/tiny_mce.js"></script>
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
<div style="clear:both;"></div>
<div class="bid_details" style="background-color:#ffffff !important;">
<?php
$bid_price=mysql_fetch_array(mysql_query("select bid_price from product_info where id=".$product_id));
?>
<form type="POST" action="submit_bid.php" method="post" onSubmit="return formValidate(this,'0',<?=$bid_price['bid_price']?>);">
<table align="left" border="0" class="products_table" style="background-color: #FFFFFF;
    border-radius: 5px 5px 5px 5px;
    margin: 20px 0 0;
    padding: 10px;
    box-shadow: 0 1px 1px 0 #686868;">
    
    
    <tr>
	<?php if(isset($_SESSION['check_price']) && $_SESSION['check_price']!=''){  ?>
    	<td colspan="3" align="center">
        <div class="validation_message">
        <?php
		if($_SESSION['check_price']==1){
			echo 'There are some error(s) in the form';
		}else if($_SESSION['check_price']==2){
			echo 'Bid Price should not be less than the Regular Price (Rs. '.$bid_price['bid_price'].')';	
		}
		?>
        </div>
		</td>
        <?php } ?>
    </tr>
    
    
    
    
	<tr><td>Bid Amount</td>
    <td>:</td>
    <td><input type="text" autocomplete="off" name="bid_amount" class="bid_amount pdt_t_inp" id="bid_amount" onkeypress="return isNumberKey(event)" onblur="check_price(this.value,<?=$bid_price['bid_price']?>)"/></td></tr>
	
    <tr><td colspan="3"><div id="price_alert" class="js_alert"></div></td></tr>
    
    <tr><td>Final Amount</td>
    <td>:</td>
    <td><input type="text" name="final_amount" class="final_amount pdt_t_inp" id="final_amount" disabled="disabled" style="cursor: no-drop; background:#F0F0F0;"/></td></tr>
	
    <tr><td>Query</td>
    <td>:</td>
    <td><textarea name="description" id="description" class="description" cols="25" rows="5"></textarea></td></tr>
    
    <tr><td colspan="3"><div id="description_alert" class="js_alert"></div></td></tr>
    
	<tr>
        <td colspan="3">
        <input type="hidden" name="regular_price" value="<?=$bid_price['bid_price']?>"/>
        <input type="hidden" name="product_id" value="<?=$product_id?>"/>
        <input class="view_button" type="submit" name="submit" value="SUBMIT"/> &nbsp;&nbsp;
        <input class="view_button" style="margin-right: 5px;" type="reset" name="reset" value="RESET"/>
        </td>
    </tr>
</table>
</form>

</div>
<!--===================================================================================================================-->



<div style="clear:both;"></div>
<input class="back_btn" type="button" name="back" value="Back" onClick="history.back();" >
<div style="clear:both;"></div>

<!--<div style="background-color:#666; width:100%; height:30px;">&nbsp;</div>-->

<table border="0" width="100%">
	<tr><td colspan="3">&nbsp;</td></tr>
    <?php
$sql_bid=mysql_query("select id,user_id,product_id,description,bid_price,DATE_FORMAT(bid_date,'%W, %M %d, %Y') as bid_dt,final_bid_price from bid_info where product_id=".$product_id);
$r_count=mysql_num_rows($sql_bid);
if($r_count>0){ ?>
<div class="auction_product" style="margin-left: -30px;"><img src="images/auction_product_bg.png">BID DETAILS</div>
<center><div class="validation_message"></div></center>
<?php	
}
while($bid_res=mysql_fetch_array($sql_bid)){ 
	$sql_img=mysql_fetch_array(mysql_query("select image,user_name from user_info where id=".$bid_res['user_id'])); ?>
    <tr>
    	<td colspan="3">
        	<div class="product_dell">
        	<table width="100%" border="0">
            	<tr>
                	<td width="10%" rowspan="3" valign="top" align="center" style="padding-top:10px;"><img class="nice_img" src="ProfileImage/thumbs/<?=$sql_img['image']?>" width="70"></td>
                	<td style="padding:3px; font-size:12px;">
                    <span style="font-size:18px; font-weight:bold;"><?=$sql_img['user_name']?></span>
                    <span style="float:right;"><img  style="margin-right:5px;" src="images/calendar4.png"><?=$bid_res['bid_dt']?></span></td>
                </tr>
                <tr>
                	<td style="padding:3px;"><?=$bid_res['description']?></td>
                </tr>
                <tr>
                    <td style="padding:3px; font-weight:bold;" align="right">Bid Price : Rs. <?php echo round($bid_res['final_bid_price'],2); ?></td>
                </tr>
                    
                <tr>
                    <td colspan="2" align="right" class="edit_u_bid"> 
                            <?php
								if($bid_res['user_id']==$_SESSION['user_id']){
							?>
                            <a id="fancybox" href="edit_bid.php?id=<?=$bid_res['id']?>" >Edit your Bid Details</a>
                            <?php } ?>              
                    </td>
                </tr>
            </table>
<!-- =====================================MESSAGES[start]======================================================== -->	
<?php if($bid_res['user_id']==$_SESSION['user_id'] || $result_of_s_type['user_id']==$_SESSION['user_id']){ ?>	
				<div class="global_messages">
<?php
	if($bid_res['user_id']!=$_SESSION['user_id']) { 
		$bidder_id=$bid_res['user_id']; 
	 	$seller_id=$_SESSION['user_id'];  
	}
	
	else{ 
	    $bidder_id=$_SESSION['user_id'];
		$seller_id=$product['user_id'];
	}	
?>		
<input type="hidden" id="seller_id<?=$bid_res['id']?>" value="<?=$seller_id?>">		
<input type="hidden" id="bidder_id<?=$bid_res['id']?>" value="<?=$bidder_id?>">		
<input type="hidden" id="product_id<?=$bid_res['id']?>" value="<?=$product_id?>">		
<input type="hidden" id="msg_id<?=$bid_res['id']?>" value="<?=$_SESSION['user_id']?>">		
<input type="hidden" id="bid_id<?=$bid_res['id']?>" value="<?=$bid_res['id']?>">	

<span style="cursor:pointer;font-weight:bold;" id="enter_message<?=$bid_res['id']?>">Post Message</span>

<div id="message_box<?=$bid_res['id']?>">
<textarea id="global_message<?=$bid_res['id']?>"></textarea>
<input type="button" id="send_message<?=$bid_res['id']?>" value="Post Message">
</div>

<script>
$('#message_box<?=$bid_res['id']?>').hide();
$('.validation_message').hide();
$('#enter_message<?=$bid_res['id']?>').click(function() {
	$('#message_box<?=$bid_res['id']?>').fadeToggle('slow');
});

$('#send_message<?=$bid_res['id']?>').click(function() {
	var seller_id=$('#seller_id<?=$bid_res['id']?>').val();
	var bidder_id=$('#bidder_id<?=$bid_res['id']?>').val();
	var product_id=$('#product_id<?=$bid_res['id']?>').val();
	var msg_id=$('#msg_id<?=$bid_res['id']?>').val();
	var global_message=tinyMCE.get('global_message<?=$bid_res['id']?>').getContent();
	var bid_id=$('#bid_id<?=$bid_res['id']?>').val();

 if(global_message!=''){	
	  
		$('.validation_message').html('<center>Please Wait...</center>');
	  
		$.post('ajax_pages/messages.php',{seller_id:seller_id,bidder_id:bidder_id,product_id:product_id,msg_id:msg_id,
									 global_message:global_message,bid_id:bid_id},function(data){
	
			$('.validation_message').fadeIn('slow').html(data);
			
			$('.validation_message').append("<a style='margin-left:5px;' href='#'><img src='images/refresh.png'></a>");
		});
		
		$('#message_box<?=$bid_res['id']?>').fadeOut(1000);
		
	  }
	  else{
	  
	     alert('message cannot be empty');
	  } 

});
</script>				
				
					<h4 style="cursor:pointer;" class="show_messages_holder<?=$bid_res['id']?>">View Messages</h4>
<?php 
	$MESSAGES=mysql_query("SELECT * FROM messages WHERE bid_id=".$bid_res['id']);
?>					
				<div id="messages_holder<?=$bid_res['id']?>">
					<table border="0">
<?php 
			while($msg_row=mysql_fetch_array($MESSAGES)) {
?>					
					   <tr>
							<td><?php 
				$USER_NAME=mysql_fetch_array(mysql_query("SELECT user_name FROM user_info WHERE id=".$msg_row['msg_id']));				
								echo $USER_NAME['user_name'];
								?>
							</td>
							<td>:</td>		
							<td><?php echo $msg_row['message'];?></td>		
					   </tr>	   
<?php
  } //END OF WHILE
?>					   
					   
					</table>
				</div>
<script>
	$('#messages_holder<?=$bid_res['id']?>').hide();
	$('.show_messages_holder<?=$bid_res['id']?>').click(function() {
		$('#messages_holder<?=$bid_res['id']?>').slideToggle('slow');
	});
</script>		
				</div>
	<?php }?>			
<!-- ======================================MESSAGES[end]====================================================== -->					
           </div>
			
    	</td>
    </tr>
<?php
} // END OF OUTER WHILE  line 348 /////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td colspan="3">&nbsp;</td></tr>
</table>
<!-- -----------------------start-------------------------- -->
<script src="js/jquery.jqzoom-core.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/jquery.jqzoom.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
	$('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false
        });
});
</script>
<!-- -----------------------end-------------------------- -->
</div>
<?php include("footer.php"); ?>