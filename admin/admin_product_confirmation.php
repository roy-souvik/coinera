<?php
error_reporting(0);
ob_start();
require("admin_utils.php");

if($_SESSION['admin_userid']==''){
	header('Location: index.php');
}
?>

<?php
	if($_POST['mode']=='add' || $_POST['mode']=='edit') 		disphtml("show_add_edit($_POST[id]);");
	elseif($_POST['mode']=='update')							update_record($_POST['id']);
	elseif($_POST['mode']=='active_deactive')					active_deactive($_POST['id']);
	elseif($_POST['mode']=='delete_rec')						delete_record($_POST['id']);
	else    													disphtml("main();");
	
ob_end_flush();
function main()
{
	if($_POST[hold_page] > 0)  $GLOBALS[start] = $_POST[hold_page];
	$sql="SELECT count(*) FROM user";
	$res=mysql_query($sql);
	$row = mysql_fetch_row($res);
    $count =  $row[0];
	if ($_POST[search_mode]=="ALPHA")
	{
	$color_sql="SELECT * FROM product_status where order_no like '$_POST[txt_alpha]%'" . " ORDER BY entry_date DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM product_status where order_no like '$_POST[txt_alpha]%'"  . " ORDER BY entry_date DESC"));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="SEARCH")
	{
	$color_sql="SELECT * FROM product_status where order_no like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY entry_date DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM product_status where order_no like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY entry_date DESC"));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="")
	{
		$color_sql="SELECT *  FROM product_status WHERE order_no!='' LIMIT $GLOBALS[start],$GLOBALS[show]";
		$row=mysql_fetch_array(mysql_query("select count(*) FROM product_status WHERE order_no!=''"));
		$count=$row[0];
	}
	$rs=mysql_query($color_sql);
?>
<link rel="stylesheet" href="css/default.css" type="text/css">
<?php /* 

	<form name = "frmSearch" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="search_mode" value="<?=$_POST['search_mode']?>">
	<input type="hidden" name="txt_alpha" value="<?=$_POST['txt_alpha']?>"><BR>
	
  <table width="99%" align="center" border="0" class="ThinTable" cellpadding="5" cellspacing="1">
    <tr class="TDHEAD"> 
      <td colspan="6">Search Panel</td>
    </tr>
	
	<tr class="content">
<td colspan="3"></td>
      <td class="text_normal">Search By</td>
      <td>:</td><td><select name="search_type" class="combo">
          <option value="">Select One</option>
          <option value="title">name</option>
        </select>
	&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="txt_search" type="text" class="textbox" value="<?=stripslashes($_REQUEST['txt_search']);?>">
	&nbsp;&nbsp;
        <input type="button" class="button" onClick="search_text()" value="Search">
	&nbsp;&nbsp;&nbsp;
        <input name="btnShowAll" type="button" class="button" value="Show All" onClick="javascript:show_all();">
	</td></tr>
	
	<tr><td colspan="6" align="center"><? DisplayAlphabet(); ?></td></tr>

	</table><br>
	</form>
*/
?>	
<script language="JavaScript">
function show_all()
{
	document.frmSearch.search_mode.value = "";	
	document.frmSearch.txt_search.value="";
	document.frmSearch.txt_alpha.value="";
	document.frmSearch.search_type.value="";
	document.frmSearch.submit();	
}
	
function search_text()
{
	if(document.frmSearch.search_type.value=="")
	{
		alert("Please Select A Search Type");
		return false;
	}
	if(document.frmSearch.txt_search.value.search(/\S/)==-1)
	{
		alert("Please Enter Search Criteria");
		return false;
	}
	document.frmSearch.search_mode.value = "SEARCH";
	document.frmSearch.submit();
}

function search_alpha(alpha)
{
	document.frmSearch.search_mode.value = "ALPHA";
	document.frmSearch.txt_search.value = '';
	document.frmSearch.txt_alpha.value = alpha;
	document.frmSearch.submit();
}	
</script>	

<script language="javascript">
/*function Add()
{
	document.frm_opts.mode.value="add";
	document.frm_opts.id.value="";
	document.frm_opts.submit();
}
*/
function Edit(ID,record_no)
{
	document.frm_opts.mode.value='edit';
	document.frm_opts.id.value=ID;
	document.frm_opts.hold_page.value = record_no*1;
	document.frm_opts.submit();
}

function ChangeStatus(ID,record_no)
{
	document.frm_opts.mode.value='change_status';
	document.frm_opts.id.value=ID;
	document.frm_opts.hold_page.value = record_no*1;
	document.frm_opts.submit();
}
function Delete(ID,record_no)
{
	var UserResp = window.confirm("Are you sure to remove this?");
	if( UserResp == true )
	{
		document.frm_opts.mode.value='delete_rec';
		document.frm_opts.id.value=ID;
		document.frm_opts.hold_page.value = record_no*1;
		document.frm_opts.submit();
	}
}
function active_deactive(id,record_no)
		{
			document.frm_opts.mode.value='active_deactive';
			document.frm_opts.id.value=id;
			document.frm_opts.hold_page.value = record_no*1;
			document.frm_opts.submit();
		}
</script>


<?php if(isset($_POST['msg'])){
	$msg=$_POST['msg'];
	 echo "".$GLOBALS['err_msg']."";
	
	}?>
<table width="99%" align="center" border="0" cellpadding="5" cellspacing="1">
		<input type="hidden" name="mode" value="<?=$_POST['mode']?>">
		<input type="hidden" name="id" value="" >
        <input type="hidden" name="status" >
		<tr> 
			<td width="87%" align="center" class="ErrorText"><?=$GLOBALS['err_msg']?> </td>
			
   <!-- <td width="7%" align="right"><a href="javascript:document.frm_opts.submit();" title=" Refresh the page"><img border="0" src="images/icon_reload.gif"></a></td>
			
    <td align="right" width="6%"><a href="javascript:add_color();" title=" Add Product"><img src="images/plus_icon.gif" border="0"></a></td>-->
		</tr>
	</table>
<table width="99%" align="center" border="0" cellpadding="5" cellspacing="2"  class="ThinTable">
  		  <tr class="TDHEAD"> 
            <td colspan="9" align="left"  class="text_main_header">Product Confirmations</td>
          </tr>
  <?php 
	if($count == 0)
	{ 
	?>
  <tr> 
    <td align="center" colspan="11">No records found</td>
  </tr>
  <?
	}
	else
	{	
	?>
  <tr class="text_normal"> 
    <td width="6%" bgcolor="#CFC5BC"><strong>SL</strong></td>
    <td width="21%" bgcolor="#CFC5BC"><strong>Order No.</strong></td>
    <td width="18%" bgcolor="#CFC5BC"><strong>Seller</strong></td>
    <td width="12%" bgcolor="#CFC5BC"><strong>Buyer</strong></td>
    <td width="22%" bgcolor="#CFC5BC"><strong>Purchase Date</strong></td>
    <td width="25%" bgcolor="#CFC5BC"><strong>Product Image</strong></td>
	<td width="18%" bgcolor="#CFC5BC"><strong>Product Name</strong></td>
    <td width="6%" align="center" bgcolor="#CFC5BC"><strong>Mail</strong></td>
    <td width="8%" align="center" bgcolor="#CFC5BC"><strong>Delete</strong></td>
  </tr>
<?php
$cnt=$GLOBALS[start]+1;
while($rec=mysql_fetch_array($rs))
{
//GET PRODUCT INFORMATION
$product=mysql_fetch_array(mysql_query("SELECT title,images,user_id FROM `product_info` WHERE id=".$rec['product_id']));
//GET SELLER INFORMATION
$seller=mysql_fetch_array(mysql_query("SELECT id,user_name FROM `user_info` WHERE id=".$product['user_id']));
//GET BUYER INFORMATION			
$buyer=mysql_fetch_array(mysql_query("SELECT id,user_name FROM `user_info` WHERE id=".$rec['winner_id']));			
//////////////////////
$orderdate = explode('-',$rec['purchase_date']);
$purchase_date=$day = $orderdate[2]."-".$orderdate[1]."-".$orderdate[0];
?>
  <tr onMouseOver="this.bgColor='<?=SCROLL_COLOR;?>'" onMouseOut="this.bgColor=''" class="text_small"> 
    <td valign="top"><?=$cnt++ ?></td>
    <td valign="top"><?=$rec['order_no']?></td>
    <td valign="top"><?=$seller['user_name']?></td>
    <td valign="top"><?=$buyer['user_name']?></td>
    <td valign="top"><?=$purchase_date?></td>
    <td valign="top" align="center">
    <?php if($product['images']!=''){ ?>
    <img src='../ProductImage/thumbs/<?=stripslashes($product['images']);?>' width="70" />
    <?php }else{ 
		echo "No Image found";
		} ?>
    </td>
    <td align="center"><?=$product['title']?></td>
	
    <td align="center">
<?php
	$MAIL_STATUS=mysql_query("SELECT user_id,product_id FROM `seller_info` WHERE user_id=".$seller['id']." AND product_id=".$rec['product_id']);
	
	if(mysql_num_rows($MAIL_STATUS)==0){
?>	
		<a href="send_mail.php?seller_id=<?=$seller['id'];?>&prod_id=<?=$rec['product_id'];?>&buyer=<?=$buyer['id'];?>" title="Send Mail">
		   <img src="images/mail.png" border="0">
	    </a>
<?php }
	  else{
?>	
		<a href="#" title="Mail Already Sent" onclick="alert('Mail already sent')">
		   <img src="images/mail_sent.png" border="0">
	    </a>
<?php } //end of else ?>	
	</td>
	
    <td align="center"><a href="javascript:Delete(<?=$rec['id'];?>,<?=$GLOBALS[start]?>)" title="Delete order number"><img name="xx" src="images/delete_icon.gif" border="0"></a></td> 
  </tr>
  <?php 
		} // end of while loop
	} // end of page count
	?>
</table>
	<?php 
		if($count>0 && $count > $GLOBALS[show])	
		{
	?>
	<table width="90%" align="center" border="0" cellpadding="5" cellspacing="2">
		<tr>
			<td><? pagination($count,"frm_opts");?></td>
		</tr>
	
	</table>
	<?php
		}
	?>
	<br>
	<form name="frm_opts" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
		<input type="hidden" name="mode">
		<input type="hidden" name="pageNo" value="<?=$_POST[pageNo]?>">
		<input type="hidden" name="url" value="manage_user.php">
		<input type="hidden" name="id" value="">
		<input type="hidden" name="search_type" value="<?=$_POST[search_type]?>">
		<input type="hidden" name="search_mode" value="<?=$_POST['search_mode']?>">
		<input type="hidden" name="txt_alpha" value="<?=$_POST['txt_alpha']?>">
		<input type="hidden" name="txt_search" value="<?=$_POST['txt_search']?>">
		<input type="hidden" name="hold_page" value="">
	</form>
	<script language="JavaScript">
	function add_color()
		{
			document.frm_opts.mode.value='add';
			document.frm_opts.submit();
		}
	</script>

<?php
}//End of main()
function delete_record($id)
{
	$query=mysql_query('select image from product_status where id = '.$id);
	$image=mysql_fetch_array($query);
	unlink(realpath('../ProfileImage/thumbs/'.$image['image']));
	unlink(realpath('../ProfileImage/normal/'.$image['image']));

	
	$sql_query="DELETE FROM product_status WHERE id='".$id."'";
	mysql_query($sql_query) or die(mysql_error()." Error in  deletion.");

	$GLOBALS['err_msg']="Information deleted successfully";
	disphtml("main();");
}
?>