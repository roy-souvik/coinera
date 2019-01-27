<?php
session_start();
include("includes/config.php");
include("includes/dbcon.php");

error_reporting(0);
$bid_id=$_REQUEST['id'];
?>
 <link rel="stylesheet" media="screen" type="text/css" href="css1/style.css" />
 <link rel="stylesheet" media="screen" type="text/css" href="css1/reset.css" />
 
 <style type="text/css">
.js_alert {
	color:#F00;
	font-size:12px;	
	line-height: 21px;
}
 </style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
 <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
 
<script language="javascript">

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

<?php
$sql_bid=mysql_query("select id,user_id,product_id,description,bid_price,DATE_FORMAT(bid_date,'%W, %M %d, %Y') as bid_dt,final_bid_price from bid_info where id=".$bid_id);
$bid_res=mysql_fetch_array($sql_bid);
?>



    <div id="feedback" style="width:485px;padding:25px; height:245px;">
    <table width="420px" cellspacing="0" cellpadding="0" border="0" align="center">
	 <tr>
     
     	<td>
  		 <form type="POST" action="submit_bid.php?edt=<?=$bid_id?>" method="post" onSubmit="return formValidate(this,'0');">
<table width="103%" border="0">
	<tr>
    	<td colspan="3" align="center">
        <?php if(isset($_REQUEST['edt_id']) && $_REQUEST['edt_id']!=''){ 
		 	echo 'Bid Information Updated Successfully'; 
		 }else{?>
			&nbsp;
		 <?php } ?>
        </td>
    </tr>
    <tr><td colspan="3" align="center">&nbsp;</td></tr>

	<tr><td style="width:85px;">Bid Amount</td>
    <td style="width:2px;">:</td>
        <td>
            $<input type="text" autocomplete="off" name="bid_amount" class="bid_amount" id="bid_amount" value="<?=$bid_res['bid_price']?>" onkeypress="return isNumberKey(event)"/>
            <div id="price_alert" class="js_alert"></div>
        </td>
    </tr>
	<tr><td>Final Amount</td>
    <td>:</td>
        <td>
        	$<input type="text" name="final_amount" class="final_amount" value="<?=round($bid_res['final_bid_price'],2)?>" id="final_amount" disabled="disabled"/>
        </td>
    </tr>
	<tr><td>Description</td>
    <td>:</td>
        <td>
            <textarea name="description" id="description" class="description" cols="25" rows="5"><?=$bid_res['description']?></textarea>
            <div id="description_alert" class="js_alert"></div>
        </td>
    </tr>
	<tr>
        <td colspan="2">&nbsp;</td>
        <td>
        <input type="hidden" name="product_id" value="<?=$bid_res['product_id']?>"/>
        <input type="submit" name="submit" value="SUBMIT"/> &nbsp;&nbsp;
        <input type="reset" name="reset" value="RESET"/>
        </td>
    </tr>
</table>
</form>
	  </td>
	</tr>
  </table>
 </div>
