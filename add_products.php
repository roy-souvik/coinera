<?php
error_reporting(0);
$GLOBALS['msg']='';
?>
<?php include("header.php"); ?>



<?php
if(!isset($_SESSION['user_id'])){

	header("location:index.php");
	
}
?>
<style type="text/css">
	.ui-datepicker {
		font-size: 11px;
	}

 .js_alert {
	color:#F00;
	font-size:12px;	
	line-height: 21px;
	padding-left: 120px;
	}
	
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



function addElement() 
    {
        var ni = document.getElementById('myDiv');
        var numi = document.getElementById('theValue');
        if(numi.value < 2)
        {
            var num = (document.getElementById('theValue').value -1)+ 2;
            numi.value = num;
            var newdiv = document.createElement('div');
            var divIdName = 'my'+num+'Div';
			var nums=num+1;
            newdiv.setAttribute('id',divIdName);
      newdiv.innerHTML = '<input name=\'image_name[]\' type=file >&nbsp;<a href=javascript:; onclick=removeEvent("'+divIdName+'")>Remove</a><br>';
            ni.appendChild(newdiv);
        }
        else
            //alert('You can attach maximum 3 files');
			document.getElementById('image_alert1').innerHTML = "You can attach maximum 3 files";
    
    }
    function removeEvent(divNum) 
    {
        var d = document.getElementById('myDiv');
        document.getElementById('theValue').value = document.getElementById('theValue').value - 1;
        var olddiv = document.getElementById(divNum);
        d.removeChild(olddiv);
    }




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




<?php
include("includes/config.php");
include("includes/dbcon.php");

require_once("includes/image_upload_func.php");
require_once("includes/image_resize_func.php");
?>

<?php
if(isset($_POST['p_upload']) && $_POST['p_upload']!='')
{
	
	
	//$filename=upload_image(realpath('ProductImage/normal/'),realpath('ProductImage/thumbs/'));
	
	$p_cat_id=mysql_real_escape_string($_POST['sub_category']);
	
	$p_cat_p=mysql_fetch_array(mysql_query("select p_id from category_info where id=".$p_cat_id));
	$p_cat_p_id=$p_cat_p['p_id'];
	
	$p_title=mysql_real_escape_string($_POST['title']);
	$p_subtitle=mysql_real_escape_string($_POST['sub_title']);
	$p_description=mysql_real_escape_string($_POST['description']);
	$p_bid_price=mysql_real_escape_string($_POST['bid_price']);
	$p_direct_price=mysql_real_escape_string($_POST['direct_price']);
	
	if($p_bid_price!=''){
		$p_price=$p_bid_price;
	}else{
		$p_price=$p_direct_price;
	}
	$p_s_date=$_POST['start_date'];
	$p_end_date=$_POST['end_date'];
	$p_quantity=mysql_real_escape_string($_POST['quantity']);
	$p_uid=$_SESSION['user_id'];
	
		if($p_cat_id!='' && $p_title!='' && $p_subtitle!='' && $p_description!='' && $p_price!='' && $p_cat_id!='' && $p_s_date!='' && $p_end_date!='' && $p_quantity!=''){
			$sql="INSERT INTO product_info
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
				  quantity = '".$p_quantity."'";
			mysql_query($sql);
			$GLOBALS['msg']='Product Inserted Successfully';
			$product=mysql_fetch_array(mysql_query("SELECT id FROM product_info ORDER BY id DESC LIMIT 1"));
			//$product['id'].'<br>';
			$image_name_file=isset($_REQUEST["image_name_file"])?$_REQUEST["image_name_file"]:"";
			$image_meterial_name_file=$_FILES[$image_name_file]['name'];
			$image_meterial_name_file_temp=$_FILES[$image_name_file]['tmp_name'];
			if(!empty($image_meterial_name_file))
	  		{
			  	for($i=0;$i<count($image_meterial_name_file);$i++)
			  	{
					if(!empty($image_meterial_name_file[$i]))
					{
						$fnames[$i] = rand(1111,9999999)."_".$image_meterial_name_file[$i];
						
						if(move_uploaded_file($_FILES[$image_name_file]["tmp_name"][$i], "ProductImage/normal/".$fnames[$i])) 
						{
							$image_resize = new SimpleImage();
							$image_resize->load("ProductImage/normal/".$fnames[$i]);
							$image_resize->resizeToWidth(200);
							$image_resize->save("ProductImage/thumbs/".$fnames[$i]);	
						}
						
					}
				}
				$sql="update product_info
					SET 
					images = '".$fnames[0]."',
					image2 = '".$fnames[1]."',
					image3 = '".$fnames[2]."'
					where id=".$product['id'];  
					mysql_query($sql) or die(mysql_error()."Error in Upload");
					$GLOBALS['msg']='Product Inserted Successfully';
		   	}
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
}
function price_type2() {
  document.getElementById('bid').style.display ='none';
  document.getElementById('bidl').style.display ='none';
  document.getElementById('1strw').style.display ='block';
  document.getElementById('2ndrw').style.display ='block';
  document.getElementById('cln').style.display ='block';
  document.getElementById('price').style.display ='block';
  document.getElementById('pricel').style.display ='block';
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
	document.getElementById("image_alert").innerHTML = '';
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
	
	if(!document.getElementById('s_type1').checked && !document.getElementById('s_type2').checked){
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
	
	/////////For Image checking//////////////
	img_arr = document.getElementsByName('image_name[]');
	if(!img_arr[0].value){
		var image_alert = "Please Upload an Image";
		document.getElementById('image_alert').innerHTML = image_alert;
		flag = 0;
	}else{
		path = img_arr[0].value;   
		start = path.lastIndexOf(".")                    
		if (start == -1){ 
			
			document.getElementById('image_alert').innerHTML = "Please upload .jpeg,.gif,.png,.jpg file.";
			flag = 0;                           
			//alert();  
			
		}
		else{
			start++                                       
			extension = path.substring(start, path.length).toLowerCase()  
			if ((extension != "jpg") &&  (extension != "jpeg") &&  (extension != "gif") && (extension != "png"))
			{ 
				document.getElementById('image_alert').innerHTML = "Please upload .jpeg,.gif,.png,.jpg file.";
				flag = 0;  
			 }
		}
	}
	
	/////////End Image checking//////////////
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
                <option value="<?=$sql_rec['id']?>"><?=$sql_rec['name']?></option>
                <?php
				}
				?>
            </select><!--<div id="category_alert" class="js_alert"></div>-->
        </td>
    </tr>
    <tr><td colspan="3"><div id="category_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td colspan="3" style="padding:0px !important;"><div id="s_category"></div><div id="subcategory_alert" class="js_alert"></div></td>
    	
    </tr>
    <tr><td colspan="3"></td></tr>
	<tr>
    	<td>Item Title</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="title" /><!--<div id="title_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="title_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td>Item Subitle</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="sub_title" /><!--<div id="subtitle_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="subtitle_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td valign="top">Description</td>
        <td valign="top">:</td>
        <td><textarea name="description" id="description" cols="25" rows="5"></textarea><!--<div id="description_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="description_alert" class="js_alert"></div></td></tr>
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
    <input type="hidden" name="image_name_file" value="image_name" />
    	<td>Image</td>
        <td>:</td>
        <td><!--<input class="inp_file" type="file" name="image" />--><input name="image_name[]" type="file" id="image_name[]" /> &nbsp;&nbsp;<a href="javascript:void();" onclick="addElement();">Attach more file.</a>
             <input type="hidden" value="0" id="theValue" /><!--<div id="image_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="image_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td></td>
        <td></td>
        <td><div id="myDiv"></div></td>
    </tr>
    <tr><td colspan="3"><div id="image_alert1" class="js_alert"></div></td></tr>
    <tr>
    	<td>Start Date</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="start_date" id="from"><!--<div id="start_date_alert" class="js_alert"></div>--></td>
    </tr>
    <tr><td colspan="3"><div id="start_date_alert" class="js_alert"></div></td></tr>
    <tr>
    	<td>End Date</td>
        <td>:</td>
        <td><input class="pdt_t_inp" type="text" name="end_date" id="to"><!--<div id="end_date_alert" class="js_alert"></div>--></td>
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
        	<input type="hidden" name="p_upload" value="P_upload" />&nbsp;
        	<input class="view_button" type="submit" name="sub" value="Submit" />&nbsp;
            <input style="margin-right: 5px;" class="view_button" type="reset" name="rst" value="Reset" />
        </td>
    </tr>
</table>






</form>



</div>


<?php include("footer.php"); ?>