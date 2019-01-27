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
	$color_sql="SELECT * FROM user_info where first_name like '$_POST[txt_alpha]%'" . " ORDER BY entry_date DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM user_info where first_name like '$_POST[txt_alpha]%'"  . " ORDER BY entry_date DESC"));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="SEARCH")
	{
	$color_sql="SELECT * FROM user_info where first_name like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY entry_date DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM user_info where first_name like '".stripslashes($_POST[txt_search])."%'" . " ORDER BY entry_date DESC"));
	$count=$row[0];
	}
	if ($_POST[search_mode]=="")
	{
	$color_sql="SELECT *  FROM user_info ORDER BY entry_date DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM user_info ORDER BY entry_date DESC"));
	$count=$row[0];
	}
	//echo "sql=".$country_sql;
	$rs=mysql_query($color_sql);
?>
<link rel="stylesheet" href="css/default.css" type="text/css">
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
            <td colspan="10" align="left"  class="text_main_header">Profiles</td>
          </tr>
  <?php	if($count == 0){ ?>
  <tr> 
    <td align="center" colspan="11">No records found</td>
  </tr>
  <?php	} else { ?>
  <tr class="text_normal"> 
    <td width="3%" bgcolor="#CFC5BC"><strong>SL</strong></td>
    <td width="12%" bgcolor="#CFC5BC"><strong> Name</strong></td>
    <td width="10%" bgcolor="#CFC5BC"><strong> Username</strong></td>
    <td width="20%" bgcolor="#CFC5BC"><strong> Email Id</strong></td>
    <td width="8%" bgcolor="#CFC5BC"><strong> Country</strong></td>
    <td width="14%" bgcolor="#CFC5BC"><strong> Date of Registration</strong></td>
    <td width="18%" bgcolor="#CFC5BC"><strong>Profile Picture</strong></td>
	<td width="6%" bgcolor="#CFC5BC"><strong>Status</strong></td>
    <td width="4%" align="center" bgcolor="#CFC5BC"><strong>View</strong></td>
    <td width="4%" align="center" bgcolor="#CFC5BC"><strong>Delete</strong></td>
  </tr>
  <?php
		$cnt=$GLOBALS[start]+1;
		while($rec=mysql_fetch_array($rs))
		{
  ?>
  <tr onMouseOver="this.bgColor='<?=SCROLL_COLOR;?>'" onMouseOut="this.bgColor=''" class="text_small"> 
    <td valign="top"><?=$cnt++ ?></td>
    <td valign="top"><?=$rec['first_name']?> <?=$rec['last_name']?></td>
    <td valign="top"><?=$rec['user_name']?></td>
    <td valign="top"><?=$rec['email_id']?></td>
    <td valign="top"><?=$rec['country']?></td>
    <td valign="top"><?=$rec['entry_date']?></td>
    <td valign="top" align="center">
    <?php if($rec['image']!=''){ ?>
    <img src='../ProfileImage/thumbs/<?=stripslashes($rec['image']);?>' width="70" />
    <?php }else{ ?>
    <img src='../ProfileImage/thumbs/sample.jpg' width="70" />
    <?php } ?>
    </td>
    <td align="center"><a href="javascript:active_deactive(<?=$rec['id'];?>,<?=$GLOBALS[start]?>)" title="Activate Deactivate Status"> 
    <?php if($rec['status']=='N'){	?>
      			<img src="images/icon_inactive.png"  border="0" title="Click to Activate Profile"> 
    <?php } else{ ?>
      			<img src="images/icon_active.png"  border="0" title="Click to Deactivate Profile"> 
    <?php } ?>
    
    
    
      </a></td>
    <td align="center"><a href="javascript:Edit(<?=$rec['id'];?>,<?=$GLOBALS[start]?>);" title="View User Profile Details"><img src="images/view-icon.jpg" border="0"></a></td>
    <td align="center"><a href="javascript:Delete(<?=$rec['id'];?>,<?=$GLOBALS[start]?>)" title="Delete User Profile Details"><img name="xx" src="images/delete_icon.gif" border="0"></a></td> 
  </tr>
  
  <?php 
		} // end of while loop
	} // end of page count
	?>
</table>
	<?php	if($count>0 && $count > $GLOBALS[show])	{ ?>
	<table width="90%" align="center" border="0" cellpadding="5" cellspacing="2">
		<tr>
			<td><? pagination($count,"frm_opts");?></td>
		</tr>
	
	</table>
	<?php }	?>
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


function show_add_edit($id = '')
{ 
	if($id!="")
	{	
		$current_mode = "Edit";
		$sql = "SELECT * FROM user_info WHERE id=".$id;		
		$rs  = mysql_query($sql);
		$rec = mysql_fetch_array($rs);
		
		/**Normal**/
		
		$fullname         		= $rec['first_name'].' '.$rec['last_name'];
		$image					= $rec['image'];
		$address				= $rec['address'];
		$zipcode				= $rec['zip_code'];
		$phone					= $rec['phone'];
		$email					= $rec['email_id'];
		$date_of_birth 			= $rec['date_of_birth'];
		$user_name				= $rec['user_name'];
		$city					= $rec['city'];
		$country				= $rec['country'];
		$state					= $rec['state'];
		$entry_date				= $rec['entry_date'];
		//$remarks				= $rec['remarks'];
		
		/**shipping**/
		
		$ship_full_name			= $rec['ship_first_name'].' '.$rec['ship_last_name'];
		$ship_address			= $rec['ship_address'];
		$ship_state				= $rec['ship_state'];
		$ship_city				= $rec['ship_city'];
		$ship_country 			= $rec['ship_country'];
		$ship_zip_code			= $rec['ship_zip_code'];
		$ship_phone				= $rec['ship_phone'];
		$ship_fax				= $rec['ship_fax'];
		
		/**paypal**/
		
		/*$paypal_email			= $rec['paypal_email'];
		$paypal_auth_id			= $rec['paypal_auth_id'];
		$paypal_trans_key		= $rec['paypal_trans_key'];
		$paypal_world_id		= $rec['paypal_world_id'];
		$paypal_2checkout_id	= $rec['paypal_2checkout_id'];
		$paypal_money_brk_id 	= $rec['paypal_money_brk_id'];*/
		
	}
	else{
		$current_mode = "add";
		
	} 
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" name="frmedit" >
  <input type="hidden" name="mode" value="update">
	<input type="hidden" name="id" value="<?=$id?>" >

  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="ThinTable">
  <tr>
    <td align="center"><table width="100%" align="center"  cellpadding="4" cellspacing="4" >
          <tr class="TDHEAD"> 
            <td colspan="3" align="left" style="padding-left:10px;"  class="text_main_header">View Profile Details</td>
          </tr>
          <tr> 
            <td colspan="3" align="center" ><span class="text_Msg">Date Of Registration : <?=$entry_date?></span></td>
          </tr>
          
          <tr>
			<td height="10" colspan="3"></td>		
		  </tr>
          
          <?php	if($_POST['mode']=='edit') { ?>  
          <tr>
            <td class="text_small" align="left">Profile Picture</td>
            <td class="text_small" >:</td>
            <td align="left">
             <?php if($image!=''){ ?>
            <img name="aaa" src="../ProfileImage/thumbs/<?=$image?>" width="160" alt="">
             <?php }else{ ?>
            <img src='../ProfileImage/thumbs/sample.jpg' width="160" />
            <?php } ?>
            </td>
          </tr>
		  <?php  } ?>
          
          <tr> 
            <td class="text_small" align="left">Name</td>
            <td class="text_small">:</td>
            <td align="left"><?=$fullname?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left">Username</td>
            <td class="text_small">:</td>
            <td align="left"><?=$user_name?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left">Email Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$email?></td>
          </tr>
         
          <tr> 
            <td class="text_small" align="left"> Phone No</td>
            <td class="text_small">:</td>
            <td align="left"><?=$phone?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left" valign="top"> Date Of Birth</td>
            <td class="text_small" valign="top">:</td>
            <td align="left"><?=$date_of_birth?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> City</td>
            <td class="text_small">:</td>
            <td align="left"><?=$city?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> State</td>
            <td class="text_small">:</td>
            <td align="left"><?=$state?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Country</td>
            <td class="text_small">:</td>
            <td align="left"><?=$country?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Zipcode</td>
            <td class="text_small">:</td>
            <td align="left"><?=$zipcode?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left" valign="top"> Address</td>
            <td class="text_small" valign="top">:</td>
            <td align="left"><textarea style="width: 50%;border:hidden;" rows="4"  readonly="readonly"><?=$address?></textarea></td>
          </tr>
          
          <!--<tr> 
            <td class="text_small" align="left" valign="top"> Remarks</td>
            <td class="text_small" valign="top">:</td>
            <td align="left"><textarea style="width: 50%;border:hidden;" rows="4"  readonly="readonly"><?=$remarks?></textarea></td>
          </tr>-->
          
          <tr>
			<td height="5" colspan="3"><b>Shipping Details</b></td>		
		  </tr>
          
		  <tr> 
            <td class="text_small" align="left">Name</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_full_name?></td>
          </tr>
         
          <tr> 
            <td class="text_small" align="left"> Phone No</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_phone?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Fax</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_fax?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> City</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_city?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> State</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_state?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Country</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_country?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Zipcode</td>
            <td class="text_small">:</td>
            <td align="left"><?=$ship_zipcode?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left" valign="top"> Address</td>
            <td class="text_small" valign="top">:</td>
            <td align="left"><textarea style="width: 50%;border:hidden;" rows="4"  readonly="readonly"><?=$ship_address?></textarea></td>
          </tr>  
          
         <!-- <tr>
			<td height="5" colspan="3"><b>Paypal Details</b></td>		
		  </tr>
          
		  <tr> 
            <td class="text_small" align="left">Paypal Email Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_email?></td>
          </tr>
         
          <tr> 
            <td class="text_small" align="left"> Paypal Authentication Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_auth_id?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Paypal Transaction Key</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_trans_key?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Paypal World Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_world_id?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Paypal 2D Checkout Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_2checkout_id?></td>
          </tr>
          
          <tr> 
            <td class="text_small" align="left"> Paypal Money Broker Id</td>
            <td class="text_small">:</td>
            <td align="left"><?=$paypal_money_brk_id?></td>
          </tr>-->
          
          <tr>
			<td height="10" colspan="3"></td>		
		  </tr>
           
          <tr> 
            <td height="32" >&nbsp;</td>
            <td >&nbsp;</td>
            <td class="point_txt"><!--<input name="submit" type="submit" class="inplogin" value="<?=$_REQUEST['mode']=='add'?'Add':'Update'?>">--> 
              &nbsp; 
                 <input name="button" type="button" class="inplogin" onClick="javascript:window.location='admin_profile.php';"  value="Back"> 
            </td>
          </tr>
        </table></td>
  </tr>
</table>

</form>
<?php
}

function delete_record($id)
{
	$query=mysql_query('select image from user_info where id = '.$id);
	$image=mysql_fetch_array($query);
	unlink(realpath('../ProfileImage/thumbs/'.$image['image']));
	unlink(realpath('../ProfileImage/normal/'.$image['image']));
	
	$sql_query="DELETE FROM user_info WHERE id='".$id."'";
	mysql_query($sql_query) or die(mysql_error()." Error in  deletion.");

	$GLOBALS['err_msg']="Information deleted successfully";
	disphtml("main();");
}

function active_deactive($id)
{
	$id  = trim($_POST['id']);
	$sql = "UPDATE user_info SET status = if(status = 'N','Y','N') WHERE id = '$id'";
	mysql_query($sql);
	$GLOBALS['err_msg']="Status Changed Successfully";
	disphtml("main();");
}
?>