<?php error_reporting(0);?>

<?php include("header.php"); ?>
<style type="text/css">
.js_alert {
	color:#F00;
	font-size:12px;	
	line-height: 21px;
}
 </style>


<div class="outerdiv_frame">
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
			  $url='cart.php?id='.$product[id].'&action=add';
			  $text="Add to Cart";
			  }
		
	  ?>
      <div class="phtGalLftdiv">
      
          <img src="ProductImage/thumbs/<?=$product['images']?>">
      </div>
      <div>
      		<p>Name : <font color="#ff0300"><?=$product['title']?></font>, <?=$product['sub_title']?></p>
            <p>Regular Price: <font color="#ff0300">$ <?=$price?></font></p>
            <p>Description : <font color="#ff0300"><?=$product['description']?></font></p>
            <?php if($flag==2 && $product['user_id']!=$_SESSION['user_id']){ ?>
            <p><a href="<?=$url?>"><?=$text?> </a></p>
            <?php } ?>
      </div>
	  <?php
			
	 
  }else{
		echo "<span style='color:red;'>Opps! Sorry No Product Found.</span>";
		}
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
			<a style="text-decoration:underlined;cursor:pointer;" class="show_bid_details">Bid for this Product</a>
		<?php
		}
	}
}else{ 
	if($flag==1){ ?>
	<a style="text-decoration:underlined;cursor:pointer;" onclick="alert('Please Login to Bid for this Project');">
    	Bid for this Product
    </a>
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

function formValidate(form,current_id)
{	
	//alert(s_types);
	document.getElementById("price_alert").innerHTML = '';
	var textarea = tinyMCE.get('description').getContent();
		
	
	var flag = 1;
	if(!form.bid_amount.value){
		var price_alert = "Please Enter Bid price";
		document.getElementById('price_alert').innerHTML = price_alert;
		flag = 0;
	}
	if((textarea=="") || (textarea==null)){
		document.getElementById("description_alert").innerHTML = "Please Enter Bid's Description";
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
         if (charCode > 31 && (charCode <46 || charCode > 46) && (charCode < 48 || charCode > 57)){
		 alert("Please Enter only numbers and '.' in the field !!!");
            return false;
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

	final_amount=bid_value+bid_value/100;
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
<div class="bid_details">
<form type="POST" action="submit_bid.php" method="post" onSubmit="return formValidate(this,'0');">
<table width="100%" border="0">
	<tr><td style="width:77px;">Bid Amount</td>
    <td style="width:2px;">:</td>
    <td>$<input type="text" autocomplete="off" name="bid_amount" class="bid_amount" id="bid_amount" onkeypress="return isNumberKey(event)"/><div id="price_alert" class="js_alert"></div></td></tr>
	<tr><td>Final Amount</td>
    <td>:</td>
    <td>$<input type="text" name="final_amount" class="final_amount" id="final_amount" disabled="disabled"/></td></tr>
	<tr><td>Description</td>
    <td>:</td>
    <td><textarea name="description" id="description" class="description" cols="25" rows="5"></textarea><div id="description_alert" class="js_alert"></div></td></tr>
	<tr>
        <td colspan="2">&nbsp;</td>
        <td>
        <input type="hidden" name="product_id" value="<?=$product_id?>"/>
        <input type="submit" name="submit" value="SUBMIT"/> &nbsp;&nbsp;
        <input type="reset" name="reset" value="RESET"/>
        </td>
    </tr>
</table>
</form>

</div>
<!--===================================================================================================================-->

<div style="clear:both;"></div>


<table id="fancy_load" border="0" width="100%">
	<tr><td colspan="3">&nbsp;</td></tr>
    <?php
$sql_bid=mysql_query("select id,user_id,product_id,description,bid_price,DATE_FORMAT(bid_date,'%W, %M %d, %Y') as bid_dt,final_bid_price from bid_info where product_id=".$product_id);
$r_count=mysql_num_rows($sql_bid);
if($r_count>0){ ?>
<div class="auction_product" style="margin-left: -30px;"><img src="images/auction_product_bg.png">BID DETAILS</div>
<?php
}

while($bid_res=mysql_fetch_array($sql_bid)){ 

	$sql_img=mysql_fetch_array(mysql_query("select image,user_name from user_info where id=".$bid_res['user_id'])); ?>
    <tr>
    	<td colspan="3">
        	<table width="100%" border="0">
            	<tr>
                	<td width="10%" rowspan="3" style="background-color:#CCC; padding:3px;"><img src="ProfileImage/thumbs/<?=$sql_img['image']?>" width="70"></td>
                	<td style="background-color:#CCC; padding:3px; font-size:12px;"><span style="font-size:18px; font-weight:bold;"><?=$sql_img['user_name']?></span><br /><?=$bid_res['bid_dt']?></td>
                </tr>
                <tr>
                	<td style="background-color:#CCC; padding:3px;"><?=$bid_res['description']?></td>
                </tr>
                <tr>
                    <td style="background-color:#CCC; padding:3px; font-weight:bold;">
                    <table width="100%">
                    	<tr>
                        	<td align="left">Bid Price : $<?php echo round($bid_res['final_bid_price'],2); ?></td>
                            <td align="right">
                            <?php
								if($bid_res['user_id']==$_SESSION['user_id']){
							?>
                            <a id="fancybox" class="button" href="edit_bid.php?id=<?=$bid_res['id']?>" style="display:inline-block;text-align:center;">Edit your Bid Details</a>
                            <?php } ?>
                            </td>
                        </tr>
                    </table>
                    
                    </td>
                </tr>
            </table>
    	</td>
    </tr>
<?php
}
?>

    
    
    <tr><td colspan="3">&nbsp;</td></tr>
</table>







</div>


<?php include("footer.php"); ?>