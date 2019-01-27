<?php include("header.php"); 
?>
<style>
.hotspot {color:#900; padding-bottom:1px;cursor:pointer}
#tt {position:absolute; display:block; background:url(images/tt_left.gif) top left no-repeat}
#tttop {display:block; height:5px; margin-left:5px; background:url(images/tt_top.gif) top right no-repeat; overflow:hidden}
#ttcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; background:#F6F0DB; color:#3D1602}
#ttbot {display:block; height:5px; margin-left:5px; background:url(images/tt_bottom.gif) top right no-repeat; overflow:hidden}
</style>


<div class="outerdiv_frame product_details" style="margin-top:20px;">
<?php
if(isset($_GET['prod_id'])){

	$product_id=$_GET['prod_id'];
	$user_id = $_SESSION['user_id'];

$sql=mysql_query("SELECT * FROM `product_info` WHERE user_id=".$user_id." AND `id`=".$product_id);
$num_row=mysql_num_rows($sql);
 
if($num_row > 0){
$product=mysql_fetch_array($sql);
?>
      <div class="pdt_det_cont">
      <input type="hidden" class="product_id" value="<?=$product['id'];?>">

            <h6 style="color:#744D39; font-size:12px; font-style:italic;">Posted by <?=$_SESSION['user_name']?> </h6>
            <h4 style="font-size:22px;"><?=$product['sub_title']?><hr style="height:1px;" /></h4>
            
            <div class="pdt_det_cont_d"><?=strip_tags($product['description'])?></div>
            
            <h4 style="font-size:16px;">Regular Price: <font color="#ff0300">Rs. <?=$product['bid_price']?></font></h4>            
      </div>
      
      <div class="phtGalLftdiv">
          <img src="ProductImage/thumbs/<?=$product['images']?>">
      </div>
<?php
 }
?>
<br clear="all">
        <div style="clear:both;"></div>
            <input class="back_btn" type="button" name="back" value="Back" onClick="history.back();" >
            <div style="clear:both;"></div>
        <hr/>
 <center>
	<div class="validation_message" style="display:none;"><?=$_SESSION['winner_status'];?></div>
 </center>
<?php
$var="Double click to make winner";
?> 
 <table border="0"  cellspacing="0" cellpadding="0" width="100%" class="winr_frame_table">
	<!--<tr><td width="10%"><b>Set Winner</b></td><td><center><b>Bid Details</b></center></td></tr>-->
    <tr style="font-size: 14px;">
        <td width="18%" class="winr_head_bid"><img style="margin-bottom: -6px;" src="images/winner_trophy.png">Set Winner
			<span class="hotspot" onmouseover="tooltip.show('Single click on coin icon to select a winner \n\n Double click to make winner');" onmouseout="tooltip.hide();"><img style="cursor:pointer;padding:10px 0px 0px 5px;" src="images/info.png"></span>
		</td>
        <td style="padding-left: 20px; border-left: 1px solid #C1B8A2;" class="winr_head_bid" align="center">
        <img class="hover" style="cursor:pointer;margin-bottom: -6px;margin-right: 10px;" src="images/bid_big.png">Bid Details</td>
    </tr>
    <?php
$sql_bid=mysql_query("select id,user_id,product_id,description,final_bid_price,DATE_FORMAT(bid_date,'%W, %M %d, %Y') as bid_dt from `bid_info` where product_id=".$product_id);
while($bid_res=mysql_fetch_array($sql_bid)){ 

	$sql_img=mysql_fetch_array(mysql_query("select id,image,user_name from user_info where id=".$bid_res['user_id'])); ?>
    <tr>
	  <td class="winr_inp_td">
      <div class="winr_inp_frame">
	  	  <?php if($_SESSION['winner_status']!=100) {?>
				<!--<input title="Double click to make a winner" type="radio" name="winner" id="<?//=$sql_img['id']?>" class="winner">-->
                <input title="Double click to make a winner" type="radio" name="winner" id="<?=$sql_img['id']?>" class="winner winr_inp">
                <label class="winner" id="<?=$sql_img['id']?>" for="<?=$sql_img['id']?>"><span></span></label>
		  <?php } ?>
      </div>
	  </td>
    	<td class="make_win_pdt_td"><div class="make_win_pdt_div">
        	<table width="100%" border="0">
            	<tr>
                	<td width="10%" rowspan="3" valign="top" align="center" style="padding:10px 10px 4px 7px;"><img  class="nice_img" src="ProfileImage/thumbs/<?=$sql_img['image']?>" width="70"></td>
                	<td style="padding:3px; font-size:12px;">
                    <span style="font-size:18px; font-weight:bold;"><?=$sql_img['user_name']?></span>
					<span style="float:right;"><img  style="margin-right:5px;" src="images/calendar4.png"><?=$bid_res['bid_dt']?></span>
                    </td>
                </tr>
                <tr>
                	<td style="padding:3px;text-align: justify;"><?=$bid_res['description']?></td>
                </tr>
                <tr>
                    <td style="padding:3px; font-weight:bold;" align="right">Bid Price : Rs. <?=$bid_res['final_bid_price']?></td>
                </tr>
                <tr>
                    <td colspan="2" align="right" class="edit_u_bid"> </td></tr>
            </table>
            </div>
    	</td>
    </tr>
	<tr><td><div id="dialog"></div></td></tr>
<?php
}// END OF WHILE LOOP
?> 
 
<!-- <tr><td colspan="3">&nbsp;</td></tr>-->
 <link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.10.2.custom.css"/>
 <script type="text/javascript" src="js/jquery_min_1_9.js"></script> 
 <script type="text/javascript" src="js/jquery-ui.js"></script>
 <script type="text/javascript" src="scripts/winner.js" ></script> 
 <script type="text/javascript" src="js/script.js"></script>
<script>
 /*$('.hover').click(function(){
 alert('Single click on coin icons to select winner \n\n Double click to make winner');
});*/
</script>
</table>
<?php 
}

?>

</div>
<?php include("footer.php"); ?>