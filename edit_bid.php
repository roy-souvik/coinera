<?php
session_start();
include("includes/config.php");
include("includes/dbcon.php");

error_reporting(0);
$bid_id=$_REQUEST['id'];
?>


 <style type="text/css">
.js_alert {
	color:#F00;
	font-size:12px;	
	line-height: 21px;
}

.bid_amount {
	padding-left:17px !important;
	border: 1px solid #999999 !important;
	border-radius: 6px;
	padding: 7px;
	margin: 7px 0;
	width: 338px;
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
	width: 338px;
	font-size: 14px;
	color: #555;
	-webkit-box-shadow: 0px 0px 4px #aaa !important;
	-moz-box-shadow: 0px 0px 4px #aaa !important;
	box-shadow: 0px 0px 4px #aaa !important;
	font-weight: bold;
	background:url(images/dollar.png) no-repeat !important; 
	background-position:0% 44% !important;
}

.validation_message{
display:block;
background-color:lemonchiffon;
border:1px dashed orange;
/*padding:3px;
font-size:11px;*/
text-align:center;
}
 </style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
 <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
 
<script language="javascript">

function formValidate(form,current_id,org_value)
{	
	//alert(s_types);
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
			document.getElementById('price_alert').innerHTML = "Bid Price should not be less than the Regular Price (Rs "+org_value+")";
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
		
		
		//parent.location.reload(true);
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
		document.getElementById('price_alert').innerHTML = "Bid Price should not be less than the Regular Price (Rs "+o_value+")";
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

<?php
$sql_bid=mysql_query("select id,user_id,product_id,description,bid_price,DATE_FORMAT(bid_date,'%W, %M %d, %Y') as bid_dt,final_bid_price from bid_info where id=".$bid_id);
$bid_res=mysql_fetch_array($sql_bid);

?>



    <div id="feedback">
    <table class="products_table" width="491px" border="0" align="center">
	 <tr>
     <?php
	 $bid_rec=mysql_fetch_array(mysql_query("SELECT bid_price FROM product_info WHERE bid_status='Y' AND status='Y' AND id=".$bid_res['product_id']));
	 ?>
     	<td>
       <form type="POST" action="submit_bid.php?edt=<?=$bid_id?>" method="post" onSubmit="return formValidate(this,'0',<?=$bid_rec['bid_price']?>);">
         <center>
<table width="100%" border="0" align="center">
	<tr>
	<?php if(isset($_REQUEST['edt_id']) && $_REQUEST['edt_id']!=''){  ?>
    	<td colspan="3" align="center">
        <div class="validation_message">
        <?php
		if($_REQUEST['edt_id']==1){
			echo 'Bid Information Updated Successfully';
		}else if($_REQUEST['edt_id']==2){
			echo 'Bid Price should not be less than the Regular Price (Rs '.$bid_rec['bid_price'].')';	
		}
		?>
        </div>
		</td>
        <?php } ?>
    </tr>
    <tr><td colspan="3" align="center">&nbsp;</td></tr>

	<tr><td style="width:99px;">Bid Amount</td>
    <td style="width:2px;">:</td>
        <td>
            <input type="text" autocomplete="off" name="bid_amount" class="bid_amount" id="bid_amount" value="<?=$bid_res['bid_price']?>" onkeypress="return isNumberKey(event)" onblur="check_price(this.value,<?=$bid_rec['bid_price']?>)"/>
            <div id="price_alert" class="js_alert"></div>
        </td>
    </tr>
	<tr><td>Final Amount</td>
    <td>:</td>
        <td>
        	<input type="text" name="final_amount" class="final_amount" value="<?=round($bid_res['final_bid_price'],2)?>" id="final_amount" disabled="disabled"/>
        </td>
    </tr>
	<tr><td>Query</td>
    <td>:</td>
        <td>
            <textarea name="description" id="description" class="description" cols="25" rows="5"><?=$bid_res['description']?></textarea>
            <div id="description_alert" class="js_alert"></div>
        </td>
    </tr>
	<tr>
        <td colspan="2">&nbsp;</td>
        <td style="padding:0px 10px 0px 0px !important;">
        <input type="hidden" name="regular_price" value="<?=$bid_rec['bid_price']?>"/>
        <input type="hidden" name="product_id" value="<?=$bid_res['product_id']?>"/>
        <input class="view_button" type="submit" name="submit" value="SUBMIT"/> &nbsp;&nbsp;
        <!--<input style="margin-right: 5px;" class="view_button" type="reset" name="reset" value="RESET"/>-->
        </td>
    </tr>
</table> </center>
</form>
	  </td>
	</tr>
  </table>
 
 </div>
