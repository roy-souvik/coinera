<?php
error_reporting(0);
ob_start();
date_default_timezone_set('Asia/Kolkata');
require("admin_utils.php");
require_once("../includes/image_upload_func.php");
require_once("../includes/image_resize_func.php");

if($_SESSION['admin_userid']==''){
	header('Location: index.php');
}
	$month = date("m");
	$year = date("Y");
	$str2 = substr($year, 2);
	$a = $month.$str2;
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
	$sql="SELECT count(*) FROM product_info";
	$res=mysql_query($sql);
	$row = mysql_fetch_row($res);
    $count =  $row[0];
	if ($_POST[search_mode]=="ALPHA")
	{
	$color_sql="SELECT * FROM product_info where type like '$_POST[txt_alpha]%'"  . " ORDER BY id asc LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM product_info where type like '$_POST[txt_alpha]%' and category='latest'"  . " ORDER BY id asc "));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="SEARCH")
	{
	$color_sql="SELECT * FROM product_info where type like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY type LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM product_info where type like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY id asc"));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="")
	{
	$color_sql="SELECT *  FROM product_info ORDER BY id asc LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM product_info ORDER BY id asc"));
	$count=$row[0];
	}
	$rs=mysql_query($color_sql);
?>
<link rel="stylesheet" href="css/default.css" type="text/css">
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
function Add()
{
	document.frm_opts.mode.value="add";
	document.frm_opts.id.value="";
	document.frm_opts.submit();
}

/* function Edit(ID,record_no)
{
	document.frm_opts.mode.value='edit';
	document.frm_opts.id.value=ID;
	document.frm_opts.hold_page.value = record_no*1;
	document.frm_opts.submit();
} */
function ChangeStatus(ID,record_no)
{
	document.frm_opts.mode.value='change_status';
	document.frm_opts.id.value=ID;
	document.frm_opts.hold_page.value = record_no*1;
	document.frm_opts.submit();
}
function Delete(ID,record_no)
{
	var UserResp = window.confirm("Are you sure you want to remove this product ?");
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
<?php 
  if(isset($_POST['msg'])){
	$msg=$_POST['msg'];
	 echo "".$GLOBALS['err_msg']."";
	
	}?>
<table width="99%" align="center" border="0" cellpadding="5" cellspacing="1">
		<input type="hidden" name="mode" value="<?=$_POST['mode']?>">
		<input type="hidden" name="id" value="" >
        <input type="hidden" name="status" >
		<tr> 
			<td width="87%" align="center" class="ErrorText"><?=$GLOBALS['err_msg']?> </td>	
			<td width="7%" align="right"><a href="javascript:document.frm_opts.submit();" title=" Refresh the page"><img border="0" src="images/icon_reload.gif"></a></td>
		</tr>
</table>

<table width="99%" align="center" border="0" cellpadding="5" cellspacing="2"  class="ThinTable">

  <tr class="TDHEAD"> 
            <td colspan="10" align="left"  class="text_main_header"> 
              Latest Products</td>
          </tr>
  <?php 
	if($count == 0){ 
  ?>
  <tr> <td align="center" colspan="11">No records found</td> </tr>
  <?php
	}
	else {	
  ?>
  <tr class="text_normal"> 
    <td width="4%" bgcolor="#CFC5BC"><strong>SL</strong></td>
    <td width="20%" bgcolor="#CFC5BC"><strong>Seller</strong></td>
    <td width="20%" bgcolor="#CFC5BC"><strong>Title</strong></td>
	<td width="15%" bgcolor="#CFC5BC"><strong>Price</strong></td>
    <td width="16%" bgcolor="#CFC5BC"><strong>Image</strong></td>
    <td width="20%" bgcolor="#CFC5BC"><strong>Description</strong></td>
	<td width="10%" bgcolor="#CFC5BC"><strong>Start Date</strong></td>
	<td width="10%" bgcolor="#CFC5BC"><strong>End Date</strong></td>
	<td width="6%" bgcolor="#CFC5BC" align="center"><strong>Status</strong></td>
    <td width="6%" align="center" bgcolor="#CFC5BC"><strong>Delete</strong></td>
  </tr>
  <?php
	$cnt=$GLOBALS[start]+1;
	 while($rec=mysql_fetch_array($rs))
	{			
  ?>
  <tr onMouseOver="this.bgColor='<?=SCROLL_COLOR;?>'" onMouseOut="this.bgColor=''" class="text_small"> 
    <td valign="top"><?=$cnt++ ?></td>
	<td valign="top">
	  <?php
			$user_name=mysql_fetch_array(mysql_query("SELECT `user_name` FROM user_info WHERE id=".$rec['user_id']));
			echo $user_name['user_name'];
	  ?>
	</td>
    <td valign="top"><?=$rec['title']?></td>
	<td valign="top">
    <?php
		if($rec['bid_price']!=''){ $price=$rec['bid_price'];}
		else{$price=$rec['direct_price'];}
	?>
	<?=$price?>
    </td>
    <td valign="top"><img src="../ProductImage/thumbs/<?=$rec['images']?>" width="100" /></td>
    <td valign="top">
		<?php
			if(strlen($rec['description'])>80){
			$input=substr($rec['description'],0,80);
			$result=preg_replace(array('#<p>#', '#</p>#'), '', $input, 1);
			echo $result.'....';
			}
			else{
				echo $rec['description'];
			}
		?>
    </td>
	<td valign="top"><?php echo date_formatting($rec['start_date']);?></td>
	<td valign="top"><?php echo date_formatting($rec['end_date']);?></td>
    <td align="center"><a href="javascript:active_deactive(<?=$rec['id'];?>,<?=$GLOBALS[start]?>)" type="Activate Deactivate Status"> 
    <?php
		if($rec['status']=='Y'){				
	 ?>		  <img src="images/icon_active.png"  border="0" title="Click to Deactivate Latest Product"> 
      <?php } 
	  	else
		{ ?>
      		<img src="images/icon_inactive.png"  border="0" title="Click to Activate Latest Product">
      <?php 
	  		} 
	  ?>
      </a></td>
    <td align="center"><a href="javascript:Delete(<?=$rec['id'];?>,<?=$GLOBALS[start]?>)" title="Delete Product Details"><img name="xx" src="images/delete_icon.gif" border="0"></a></td> 
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
		<input type="hidden" name="search_type" value="<?=$_POST['search_type']?>">
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
	$sql_query="DELETE FROM product_info WHERE id='".$id."'";
	mysql_query($sql_query) or die(mysql_error()." Error in  deletion.");

	$GLOBALS['err_msg']="Information deleted successfully";
	disphtml("main();");
}

function active_deactive($id)
{
	$product_id  = trim($_POST['id']);
	$sql = "UPDATE product_info SET status = if(status = 'N','Y','N') WHERE id = '$id'";
	mysql_query($sql);
	$GLOBALS['err_msg']="Status Changed Successfully";
	disphtml("main();");
}

 	function date_formatting($date)
	{	
		$new_date=explode("-",$date);
		$day=$new_date[2];
		$month=$new_date[1];
		$year=$new_date[0];
	$print_date=$day."-".$month."-".$year;
	
	return $print_date;	
	} 
?>