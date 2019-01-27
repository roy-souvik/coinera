
<?php

error_reporting(0);
$GLOBALS['msg']='';
?>
<?php include("header.php"); ?>

<?php


if($_SESSION['user_id']==''){
	header("location:index.php");
	
}




//echo $_SESSION['user_id'];
?>


<style type="text/css">
	.ui-datepicker {
		font-size: 11px;
	}

 .js_alert {
	color:#F00;
	font-size:12px;	
	line-height: 21px;
	padding-left: 150px;
	}
	#s_category td:nth-of-type(3n+1){ padding-right:42px !important;}
.validation_message{
display:block;
background-color:lemonchiffon;
border:1px dashed orange;
padding:3px;
font-size:11px;
text-align:center;
}
#my1Div{
	margin-bottom:5px;
}	
.amount_text {
	border: 1px solid #999999 !important;
	border-radius: 6px;
	padding: 7px;
	width: 310px;
	font-size: 14px;
	color: #555;
	font-weight: bold;
	background:url(images/dollar.png) no-repeat; 
	background-position:0% 44%;padding-left:17px !important;
	background-color:#FFFFFF;
}
.amount_text:focus {
	background-color:#FFFEF7 !important;
	border: 1px solid #D7C89D !important;
	box-shadow: 0 0 5px 2px #7C0000 !important;
	outline:none;
}
 </style>

<link type="text/css" href="css/ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>

<script language="JavaScript">

$(function() {
$( "#from" ).datepicker({
dateFormat: 'dd/mm/yy',
defaultDate: "+1w",
minDate: 0,
changeMonth: true,
numberOfMonths: 1,
onClose: function( selectedDate ) {
$( "#to" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#to" ).datepicker({
dateFormat: 'dd/mm/yy',
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
onClose: function( selectedDate ) {
$( "#from" ).datepicker( "option", "maxDate", selectedDate );
}
});
});
</script>
</script>



<?php
include("includes/config.php");
include("includes/dbcon.php");

require_once("includes/image_upload_func.php");
require_once("includes/image_resize_func.php");
?>

<?php
if(isset($_POST['p_upload']) && $_POST['p_upload']!='')
{
	
	if($_FILES['images']['name']!=''){
		$images=mysql_fetch_array(mysql_query("SELECT images FROM product_info where id=".$_POST['product_id']));
		unlink(realpath('ProductImage/normal/'.$images['images']));
		unlink(realpath('ProductImage/thumbs/'.$images['images']));
		$fnames = rand(1111,9999999)."_".$_FILES['images']['name'];
		if(move_uploaded_file($_FILES['images']["tmp_name"], "ProductImage/normal/".$fnames))
		{
			$image_resize = new SimpleImage();
			$image_resize->load("ProductImage/normal/".$fnames);
			$image_resize->resizeToWidth(200);
			$image_resize->save("ProductImage/thumbs/".$fnames);	
			$sql="UPDATE product_info
				  SET
				  images = '".$fnames."'
				  where id=".$_POST['product_id'];
			mysql_query($sql);
		}
	}
	if($_FILES['image2']['name']!='') {
		$image2=mysql_fetch_array(mysql_query("SELECT image2 FROM product_info where id=".$_POST['product_id']));
		if($image2['image2']!=''){
			unlink(realpath('ProductImage/normal/'.$image2['image2']));
			unlink(realpath('ProductImage/thumbs/'.$image2['image2']));
		}
		$fname2 = rand(1111,9999999)."_".$_FILES['image2']['name'];
		if(move_uploaded_file($_FILES['image2']["tmp_name"], "ProductImage/normal/".$fname2))
		{
			$image_resize = new SimpleImage();
			$image_resize->load("ProductImage/normal/".$fname2);
			$image_resize->resizeToWidth(200);
			$image_resize->save("ProductImage/thumbs/".$fname2);	
			$sql="UPDATE product_info
				  SET
				  image2 = '".$fname2."'
				  where id=".$_POST['product_id'];
			mysql_query($sql);
		}
	}
	if($_FILES['image3']['name']!='') {
		$image3=mysql_fetch_array(mysql_query("SELECT image3 FROM product_info where id=".$_POST['product_id']));
		if($image3['image3']!=''){
			unlink(realpath('ProductImage/normal/'.$image3['image3']));
			unlink(realpath('ProductImage/thumbs/'.$image3['image3']));
		}
		$fname3 = rand(1111,9999999)."_".$_FILES['image3']['name'];
		if(move_uploaded_file($_FILES['image3']["tmp_name"], "ProductImage/normal/".$fname3))
		{
			$image_resize = new SimpleImage();
			$image_resize->load("ProductImage/normal/".$fname3);
			$image_resize->resizeToWidth(200);
			$image_resize->save("ProductImage/thumbs/".$fname3);	
			$sql="UPDATE product_info
				  SET
				  image3 = '".$fname3."'
				  where id=".$_POST['product_id'];
			mysql_query($sql);
		}
	}
	$p_cat_id=mysql_real_escape_string($_POST['sub_category']);
	
	$p_cat_p=mysql_fetch_array(mysql_query("select p_id from category_info where id=".$p_cat_id));
	$p_cat_p_id=$p_cat_p['p_id'];
	
	$p_title=mysql_real_escape_string($_POST['title']);
	$p_subtitle=mysql_real_escape_string($_POST['sub_title']);
	$p_description=mysql_real_escape_string($_POST['description']);
	$p_product_price=mysql_real_escape_string($_POST['product_price']);
	if($_POST['bid_price']!=''){
		$p_bid_price=mysql_real_escape_string($_POST['bid_price']);
		$p_direct_price=mysql_real_escape_string($_POST['direct_price']);
	}else if($_POST['direct_price']!=''){
		$p_bid_price=mysql_real_escape_string($_POST['bid_price']);
		$p_direct_price=mysql_real_escape_string($_POST['direct_price']);
	} 
	else if($p_product_price!=''){
		if($_POST['product_selling_price']=='bid'){
		$p_bid_price=$_POST['product_price'];	
		}
		else if($_POST['product_selling_price']=='direct'){
		$p_direct_price=$_POST['product_price'];	
		}
	}
	$p_s_date=$_POST['start_date'];
	$p_end_date=$_POST['end_date'];
	$p_quantity=mysql_real_escape_string($_POST['quantity']);
	$p_uid=$_SESSION['user_id'];
	
		if($p_cat_id!='' && $p_title!='' && $p_subtitle!='' && $p_description!='' && $p_cat_id!='' && $p_s_date!='' && $p_end_date!='' && $p_quantity!=''){
			$sql="UPDATE product_info
				  SET
				  user_id = '".$p_uid."',
				  cat_id = '".$p_cat_id."',
				  cat_p_id = '".$p_cat_p_id."',
				  title = '".$p_title."',
				  sub_title = '".$p_subtitle."',
				  bid_price = '".$p_bid_price."',
				  direct_price = '".$p_direct_price."',
				  description = '".$p_description."',
				  entry_date = CURDATE(),
				  start_date = STR_TO_DATE('".$p_s_date."','%d/%m/%Y'),
				  end_date = STR_TO_DATE('".$p_end_date."','%d/%m/%Y'),
				  quantity = '".$p_quantity."'
				  where id=".$_POST['product_id'];
			mysql_query($sql);
			$GLOBALS['msg']='Product Updated Successfully';
		}else{
			$GLOBALS['msg']='There are some error(s) in the form';
			//header("location:products.php");
	
		}
}
?>

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

<script language="javascript">
function cate(id) {
	//alert(id);
	  if(window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	  else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		  document.getElementById("s_category").innerHTML=xmlhttp.responseText;
	  }
	  xmlhttp.open("GET","ajax_pages/sub_category.php?id="+id,true);
	  xmlhttp.send();
	} 
function price_type1() {
  document.getElementById('bid').style.display ='block';
  document.getElementById('bidl').style.display ='block';
  document.getElementById('cln').style.display ='block';
  document.getElementById('1strw').style.display ='block';
  document.getElementById('2ndrw').style.display ='block';
  document.getElementById('price').style.display ='none';
  document.getElementById('pricel').style.display ='none';
  document.getElementById('common_pricel').style.display ='none';
  document.getElementById('common_price').style.display ='none';
  document.getElementById('common_cln').style.display ='none';
}
function price_type2() {
  document.getElementById('bid').style.display ='none';
  document.getElementById('bidl').style.display ='none';
  document.getElementById('1strw').style.display ='block';
  document.getElementById('2ndrw').style.display ='block';
  document.getElementById('cln').style.display ='block';
  document.getElementById('price').style.display ='block';
  document.getElementById('pricel').style.display ='block';
  document.getElementById('common_pricel').style.display ='none';
  document.getElementById('common_price').style.display ='none';
  document.getElementById('common_cln').style.display ='none';
}

function show1() {
  document.getElementById('edit1').style.display ='none';
  document.getElementById('delete1').style.display ='block';
  document.getElementById('images').style.display ='block';
}
function hide1() {
  document.getElementById('edit1').style.display ='block';
  document.getElementById('delete1').style.display ='none';
  document.getElementById('images').style.display ='none';
}
function show2() {
  document.getElementById('edit2').style.display ='none';
  document.getElementById('delete2').style.display ='block';
  document.getElementById('image2').style.display ='block';
}
function hide2() {
  document.getElementById('edit2').style.display ='block';
  document.getElementById('delete2').style.display ='none';
  document.getElementById('image2').style.display ='none';
}
function show3() {
  document.getElementById('edit3').style.display ='none';
  document.getElementById('delete3').style.display ='block';
  document.getElementById('image3').style.display ='block';
}
function hide3() {
  document.getElementById('edit3').style.display ='block';
  document.getElementById('delete3').style.display ='none';
  document.getElementById('image3').style.display ='none';
}

function isNumberKeys(evt)
{
	document.getElementById("price_alert").innerHTML = '';
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode <46 || charCode > 46) && (charCode < 48 || charCode > 57)){
		var price_alert = "Please Enter only numbers and '.' in the field !!!";
		document.getElementById('price_alert').innerHTML = price_alert;
		return false;
	}
	return true;
}




function formValidate(form,current_id)
{	
	//alert(s_types);
	document.getElementById("category_alert").innerHTML = '';
	document.getElementById("subcategory_alert").innerHTML = '';
	document.getElementById("title_alert").innerHTML = '';
	document.getElementById("subtitle_alert").innerHTML = '';
	var textarea = tinyMCE.get('description').getContent();
	document.getElementById("select_type_alert").innerHTML = '';
	document.getElementById("price_alert").innerHTML = '';
	document.getElementById("start_date_alert").innerHTML = '';
	document.getElementById("end_date_alert").innerHTML = '';
	
	var pricePattern = /^[0-9._-]+\.[0-9]{2}$/;
	
	
	var flag = 1;
	if(!form.category.value){
		var category_alert = "Please Select Category";
		document.getElementById('category_alert').innerHTML = category_alert;
		flag = 0;
	}
	else{
		if(!form.sub_category.value){
			var subcategory_alert = "Please Select Subcategory";
			document.getElementById('subcategory_alert').innerHTML = subcategory_alert;
			flag = 0;
		}
	}
	if(!form.title.value){
		var title_alert = "Please Enter Product's Title";
		document.getElementById('title_alert').innerHTML = title_alert;
		flag = 0;
	}
	if(!form.sub_title.value){
		var subtitle_alert = "Please Enter Product's Subtitle";
		document.getElementById('subtitle_alert').innerHTML = subtitle_alert;
		flag = 0;
	}
	if((textarea=="") || (textarea==null)){
		document.getElementById("description_alert").innerHTML = "Please Enter Product's Description";
		flag = 0;
	}
	/////////For price checking//////////////
	
	if(document.getElementById('s_type1').checked && document.getElementById('s_type2').checked){
		var select_type_alert = "Please select Selling Type";
		document.getElementById('select_type_alert').innerHTML = select_type_alert;
		flag = 0;
	}else{
		if(document.getElementById('s_type1').checked){
			if(!form.bid_price.value){
				var price_alert = "Please Enter Bid Price";
				document.getElementById('price_alert').innerHTML = price_alert;
				flag = 0;
			}
			else if(/\./g.test(form.bid_price.value)){
				
				if(!pricePattern.test(form.bid_price.value)){
					var price_alert = "Please insert valid Price for Bid (i.e.:100 or 100.00)";
					document.getElementById('price_alert').innerHTML = price_alert;
					flag=0;
				}
			}
		}
		if(document.getElementById('s_type2').checked){
			if(!form.direct_price.value){
				var price_alert = "Please Enter Direct Price";
				document.getElementById('price_alert').innerHTML = price_alert;
				flag = 0;
			}
			else if(/\./g.test(form.direct_price.value)){
				if(!pricePattern.test(form.direct_price.value)){
					var price_alert = "Please insert valid Price for Direct sell (i.e.:100 or 100.00)";
					document.getElementById('price_alert').innerHTML = price_alert;
					flag=0;
				}
			}
		}
		
	}
	/////////End price checking//////////////
	
	
	if(!form.start_date.value){
			var start_date_alert = "Please Enter Start Date";
			document.getElementById('start_date_alert').innerHTML = start_date_alert;
			flag = 0;
	}
	if(!form.end_date.value){
			var end_date_alert = "Please Enter End Date";
			document.getElementById('end_date_alert').innerHTML = end_date_alert;
			flag = 0;
	}			
	if(flag == 0) {
		return false;
	} else {
		return true;
	}
}





</script>
<div class="outerdiv_frame">
<?php


$sql_edt=mysql_fetch_array(mysql_query("select id,user_id,cat_id,title,sub_title,bid_price,direct_price,description,images,image2,image3,DATE_FORMAT(start_date,'%d/%m/%Y') as s_date,DATE_FORMAT(end_date,'%d/%m/%Y') as e_date from product_info where id=".$_SESSION['pid']." and user_id=".$_SESSION['user_id']." and status='Y'"));
$sql_cat=mysql_fetch_array(mysql_query("select * from category_info where id=".$sql_edt['cat_id']));
$sql_edt['cat_id'];
$sql_cat['p_id'];
?>

<form name="products" method="post" action="" enctype="multipart/form-data" onSubmit="return formValidate(this,'0');">

<table class="products_table" border="0" align="center">
		<tr><td colspan="3"></td></tr>
	
 <?php 
	if($GLOBALS['msg']!=''){
 ?>	
    <tr><td colspan="3">
	
		<div class="validation_message"><?php if(($GLOBALS['msg'])!=''){ echo $GLOBALS['msg']; }?></div>
		
		</td></tr>
 <?php } ?>		
		
    <tr><td colspan="3"></td></tr>
	<tr>
    	<td>Select Category</td>
        <td>:</td>
        <td>
        	<select name="category" onchange="cate(this.value);">
            	<option value="">--Select Category--</option>
                <?php
				
				$sql_cate=mysql_query("select * from category_info where p_id=0 and status='Y'");
				while($sql_rec=mysql_fetch_array($sql_cate)){
				?>
                <option value="<?=$sql_rec['id']?>"<?=($sql_rec['id']==$sql_cat['p_id'])?'Selected':''?>><?=$sql_rec['name']?></option>
                <?php
				}
				?>
            </select><!--<div id="category_alert" class="js_alert"></div>-->
        </td>
    </tr>
    <tr><td colspan="3"><div id="category_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td colspan="3" style="padding:0px !important;">
        <div id="s_category" class="edit_p_s_cat">
        <table>
        <tr>
            <td style="padding-right:11px;">Sub Category</td>
            <td>:</td>
            <td>
                <select name="sub_category">
                    <?php
                     $sql_sub=mysql_query("select * from category_info where id=".$sql_edt['cat_id']." and status='Y'");
					 $sub_rec=mysql_fetch_array($sql_sub); 
					 ?>
                    <option value="<?=$sub_rec['id']?>"><?=$sub_rec['name']?></option>
                </select>
            </td>
        </tr>
        </table>
       </div>
        <div id="subcategory_alert" class="js_alert"></div>
        </td>
    	
    </tr>
    <tr><td colspan="3"></td></tr>
	<tr>
    	<td>Item Title</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="title" value="<?=$sql_edt['title']?>" /><!--<div id="title_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="title_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td>Item Subitle</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="sub_title" value="<?=$sql_edt['sub_title']?>" /><!--<div id="subtitle_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="subtitle_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td valign="top">Description</td>
        <td valign="top">:</td>
        <td><textarea name="description" id="description" cols="25" rows="5"><?=$sql_edt['description']?></textarea><!--<div id="description_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="description_alert" class="js_alert"></div></td></tr>
    <tr class="pro_table_ext">
    	<td valign="top">Product selling type</td>
        <td valign="top">:</td>
        <td>
        <?php
		if($sql_edt['bid_price']!='0'){
			echo 'Bid';
		}else if($sql_edt['direct_price']!='0'){
			echo 'Direct';
		}
		?>
        </td>
    </tr>
    
    <tr><td colspan="3">&nbsp;</td></tr>
     <tr class="pro_table_ext">
    	<?php
		if($sql_edt['bid_price']!='0'){ ?>
        <td valign="top">Bid Price</td>
		<td valign="top">:</td>
        <td>Rs. <?=$sql_edt['bid_price']?></td>	
        <?php
		}else if($sql_edt['direct_price']!='0'){ ?>
			<td valign="top">Direct Price</td>
            <td valign="top">:</td>
            <td>Rs. <?=$sql_edt['direct_price']?></td>	
        <?php } ?>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr class="pro_table_ext">
    	<td valign="top">Select Any type</td>
        <td valign="top">:</td>
        <td>
            <input onclick="price_type1()" type="radio" class="inp_radio" name="s_type" id="s_type1" value="bid" />
            Bid&nbsp;&nbsp;&nbsp;
            <input onclick="price_type2()" type="radio" class="inp_radio" name="s_type" id="s_type2" value="direct" />
           Direct 
            <!--<div id="select_type_alert" class="js_alert"></div>-->
        </td>
    </tr>
    <tr><td colspan="3"><div id="select_type_alert" class="js_alert"></div></td></tr>
    <tr id="1strw" style="display:none;"><td colspan="3"></td></tr>
    <tr>
    	<td>
        	<div id="bidl" style="display:none; margin-bottom: -17px;">Bid Price</div>
            <div id="pricel" style="display:none; margin-bottom: -17px;">Direct Price</div>&nbsp;
        </td>
        <td>
        	<div id="cln" style="display:none;">:</div>
        </td>
        <td>
        	<div id="bid" style="display:none;"><input class="amount_text" type="text" name="bid_price" onkeypress="return isNumberKeys(event);" /></div>
            <div id="price" style="display:none;"><input class="amount_text" type="text" name="direct_price" onkeypress="return isNumberKeys(event);" /></div>
            <!--<div id="price_alert" class="js_alert"></div>-->
        </td>
    </tr>
    <tr><td colspan="3"><div id="price_alert" class="js_alert"></div></td></tr>
    <tr id="2ndrw" style="display:none;"><td colspan="3"></td></tr>
    <tr>
    	<td valign="top">Existing Image</td>
        <td valign="top">:</td>
        <td>
        <table>
        <tr>
        <td>
        	<table>
            	<tr style="margin-bottom:10px;">
                	<td>
                    <img src="ProductImage/thumbs/<?=$sql_edt['images']?>" width="100" />
                    </td>
                	<td valign="top">
                    	<img id="edit1" onclick="show1()" style="cursor:pointer;" src="images/edit_icon.gif" />
                    </td>
                </tr>
                <tr>
                    <td valign="bottom">
                        <input name="images" style="display:none;" type="file" id="images" />
                    </td>
                    <td valign="bottom"><img id="delete1" onclick="hide1()" style="display:none; cursor:pointer;" src="images/delete.gif" /></td>
                </tr>
            </table>
		</td>
        <?php
		if($sql_edt['image2']!=''){
		?>
        <td>
            <table>
            	<tr style="margin-bottom:10px;">
                	<td>
                    <img src="ProductImage/thumbs/<?=$sql_edt['image2']?>" width="100" />
                    </td>
                	<td valign="top">
                    	<img id="edit2" onclick="show2()" style="cursor:pointer;" src="images/edit_icon.gif" />
                    </td>
                </tr>
                <tr>
                    <td valign="bottom">
                        <input name="image2" style="display:none;" type="file" id="image2" />
                    </td>
                    <td valign="bottom"><img id="delete2" onclick="hide2()" style="display:none; cursor:pointer;" src="images/delete.gif" /></td>
                </tr>
            </table>
     	</td>
        <?php } 
		if($sql_edt['image3']!=''){
		?>
        <td>
            <table>
            	<tr style="margin-bottom:10px;">
                	<td>
                    <img src="ProductImage/thumbs/<?=$sql_edt['image3']?>" width="100" />
                    </td>
                	<td valign="top">
                    	<img id="edit3" onclick="show3()" style="cursor:pointer;" src="images/edit_icon.gif" />
                    </td>
                </tr>
                <tr>
                    <td valign="bottom">
                        <input name="image3" style="display:none;" type="file" id="image3" />
                    </td>
                    <td valign="bottom"><img id="delete3" onclick="hide3()" style="display:none; cursor:pointer;" src="images/delete.gif" /></td>
                </tr>
            </table>
            </td>
            <?php } ?>
            </tr>
            </table>
            
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <?php
	if($sql_edt['image2']==''){ ?>
    <tr>
    	<td>Image2</td>
        <td>:</td>
        <td><input type="file" name="image2" /></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <?php
	}
	?>
    <?php
	if($sql_edt['image3']==''){ ?>
    <tr>
    	<td>Image3</td>
        <td>:</td>
        <td><input type="file" name="image3" /></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <?php
	}
	?>
    
    <tr>
    	<td>Start Date</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="start_date" id="from" value="<?=$sql_edt['s_date']?>"><!--<div id="start_date_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="start_date_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td>End Date</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="end_date" id="to" value="<?=$sql_edt['e_date']?>"><!--<div id="end_date_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="end_date_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td>Quantity</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="quantity" readonly="readonly" value="1" /></td>
    </tr>
    <!--<tr><td colspan="3">&nbsp;</td></tr>
    <tr>
    	<td>User ID</td>
        <td>:</td>
        <td><input type="text" name="user_id" /></td>
    </tr>-->
    <tr><td colspan="3"></td></tr>
    <tr>
        <td colspan="3" align="right">
        	<input type="hidden" name="p_upload" value="P_upload" />
            <input type="hidden" name="f_name" value="<?=$sql_edt['images']?>" />
            <input type="hidden" name="product_id" value="<?=$sql_edt['id']?>" />
            <?php
			if($sql_edt['bid_price']!='0'){ ?>
            	<input type="hidden" name="product_selling_price" value="bid" />
				<input type="hidden" name="product_price" value="<?=$sql_edt['bid_price']?>" />
            <?php
			}else if($sql_edt['direct_price']!='0'){ ?>
            	<input type="hidden" name="product_selling_price" value="direct" />
				<input type="hidden" name="product_price" value="<?=$sql_edt['direct_price']?>" />
            <?php
			}
			?>
            
            &nbsp;
        	<input class="view_button" type="submit" name="sub" value="Submit" />&nbsp;
            <input style="margin-right: 5px;" class="view_button" type="reset" name="rst" value="Reset" />
        </td>
    </tr>
</table>






</form>



</div>


<?php include("footer.php"); ?>