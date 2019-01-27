<?php
error_reporting(0);
ob_start();
require("admin_utils.php");


if($_SESSION['admin_userid']==''){
	header('Location: index.php');
}

	if($_POST['mode']=='add' || $_POST['mode']=='edit') 		disphtml("show_add_edit($_POST[id]);");
	elseif($_POST['mode']=='update')							update_record($_POST['id']);
	elseif($_POST['mode']=='active_deactive')					active_deactive($_POST['id']);
	elseif($_POST['mode']=='delete_rec')						delete_record($_POST['id']);
	elseif($_POST['mode']=='delete_img')						delete_image($_POST['id'],$_POST['img_id']);
	else    													disphtml("main();");
	
ob_end_flush();
function main()
{
	if($_POST[hold_page] > 0)  $GLOBALS[start] = $_POST[hold_page];
	//echo $_POST['pageNo'];
	$GLOBALS['show']=$GLOBALS['show']-3;
	if($GLOBALS[start]!=0){
		$mlti=$GLOBALS[start]/10;
		$mlti=$mlti*3;
		//if()
	$GLOBALS[start]=$GLOBALS[start]-$mlti;
	//echo $GLOBALS['show'];
	}
	$color_sql="SELECT *  FROM views ORDER BY id DESC LIMIT $GLOBALS[start],$GLOBALS[show]";
	$row=mysql_fetch_array(mysql_query("select count(*) FROM views ORDER BY id desc"));
	$count=$row[0];
	
	$rs=mysql_query($color_sql);
?>
<link rel="stylesheet" href="css/default.css" type="text/css">


	


<?php
	if(isset($_POST['msg'])){
	$msg=$_POST['msg'];
	 echo "".$GLOBALS['err_msg']."";
	
	}?>
<table width="90%" align="center" border="0" cellpadding="5" cellspacing="1">
		<input type="hidden" name="mode" value="<?=$_POST['mode']?>">
		<input type="hidden" name="id" value="" >
        <input type="hidden" name="status" >
		<tr> 
			<td width="87%" align="center" class="ErrorText"><?=$GLOBALS['err_msg']?> </td>
    <td width="7%" align="right"><a href="javascript:document.frm_opts.submit();" title=" Refresh the page"><img border="0" src="images/icon_reload.gif"></a></td>
			
    <!--<td align="right" width="6%"><a href="javascript:add_color();" title=" Add Banner Details"><img src="images/plus_icon.gif" border="0"></a></td>-->
		</tr>
	</table>
	
	
<table width="50%" align="center" border="0" cellpadding="5" cellspacing="2"  class="ThinTable">
  <tr class="TDHEAD"> 
            <td colspan="3" align="left"  class="text_main_header"> 
             Total Web Views</td>
          </tr>
  <?php 
	if($count == 0)
	{ 
	?>
  <tr> 
    <td align="center" colspan="3">No records found</td>
  </tr>
  <?php
	}
	else
	{	
	?>
  <tr class="text_normal"> 
    <td width="9%" bgcolor="#CFC5BC" align="center"><strong>SL</strong></td>
    <td width="30%" bgcolor="#CFC5BC" align="center"><strong>Date</strong></td>
    <td width="30%" bgcolor="#CFC5BC" align="center"><strong>Page View No.</strong></td>
	
  </tr>
  <?php
		$cnt=$GLOBALS[start]+1;
		$weekly_count=0;
		$t_week=0;
		$all_total=0;
		while($rec=mysql_fetch_array($rs))
		{
			$weekly_count=$weekly_count+1;	
		?>
  	<tr onMouseOver="this.bgColor='<?=SCROLL_COLOR;?>'" onMouseOut="this.bgColor=''" class="text_small"> 
    <td valign="top" align="center"><?=$cnt++ ?></td>
    <td valign="middle" align="center"><?=$rec['date']?></td>
    <td valign="middle" align="center"><?=$rec['view']?></td>
    
  </tr>
  
  <?php
  	 $t_week=$t_week+$rec['view'];
  			if($weekly_count==7){ 
			$weekly_count=0;
			?>
            <tr style="border:1px solid #949494;" class="text_small">
            	 <td valign="middle" align="right" colspan="3"> 
    			<table width="100%" align="center" border="0" cellpadding="5" cellspacing="2"  class="ThinTable">
                <tr>
                <td width="60%" valign="middle" align="right" colspan="2">Weekly Page Views</td>
                <td valign="middle" align="center"><?=$t_week?></td>
                </tr>
                </table>
                </td>
            </tr>
			<?php
				$t_week=0;
			}
			$all_total=$all_total+$rec['view'];
		} // end of while loop
	} // end of page count
	?>
</table>
        <?php /*?><table style="margin-top:5px;" width="50%" align="center" border="0" cellpadding="5" cellspacing="2"  class="ThinTable">
        <tr>
        <td width="60%" valign="middle" align="right" colspan="2">Total Page Views</td>
        <td valign="middle" align="center">
        <?php
        $abc=0;
			$rs1=mysql_query("select * from views");
            while($rec1=mysql_fetch_array($rs1))
            {
                $abc=$abc+$rec1['view'];						
            }
        ?>
        <?=$abc?>
        </td>
        </tr>
        </table><?php */?>
	<? 
		//echo $count.' and '.$GLOBALS['show'];
		if($count>0 && $count > $GLOBALS['show'])	
		{
	?>
	<table width="90%" align="center" border="0" cellpadding="5" cellspacing="2">
		<tr>
			<td><? pagination($count,"frm_opts");?></td>
		</tr>
	</table>
	<?
		}
	?>
	<br>
	<form name="frm_opts" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
		<input type="hidden" name="mode">
		<input type="hidden" name="pageNo" value="<?=$_POST['pageNo']?>">
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
<?
}//End of main()





?>