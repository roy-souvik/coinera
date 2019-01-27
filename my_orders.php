<?php include("header.php"); 

	if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
		header('Location:index.php');
	}

?>
<div class="myorders">
<center>
<table width="100%" cellspacing="0" cellpadding="10" border="1" padding="3">	
<tr class="myorders_title_tr" style="font-size: 14px;"> 
	<td width="85" align="center">Order Id</td>
	<td width="105" align="center">Purchase Date</td>
	<td width="85" align="center">Order Items</td>
	<td width="95" align="center">Total Amount</td>
	<td align="center">Order Status</td>
 </tr>
 
 <?php
 //echo "SELECT * FROM `product_status` WHERE `winner_id`=".$_SESSION['user_id']." ORDER BY id DESC";
	$my_orders_sql=mysql_query("SELECT * FROM `product_status` WHERE order_no!='' and `winner_id`=".$_SESSION['user_id']." ORDER BY id DESC");
	
	while($my_orders=mysql_fetch_array($my_orders_sql))
	{
	 	$price=mysql_fetch_array(mysql_query("SELECT final_bid_price FROM bid_info WHERE product_id=".$my_orders['product_id']));
	
		$my_product=mysql_fetch_array(mysql_query("SELECT title FROM product_info WHERE id=".$my_orders['product_id']));
 ?> 
  <tr  class="myorders_products_tr">
	<td align="center"><?php echo $my_orders['order_no']?></td>
	<td align="center"><?php echo $my_orders['purchase_date']?></td>
	<td align="center"><?php echo $my_product['title']?></td>
	<td align="center">Rs. <?php echo $price['final_bid_price']?></td>
	<td align="center">
		<table class="myodr_inner_tbl" width="100%" cellspacing="0" cellpadding="5" border="0" padding="0">
			
			<tr>
           	  	<td>Delivery Date : <b><?php if($my_orders['delivery_date']!='0000-00-00'){ echo $my_orders['delivery_date']; }else{ echo 'N/A'; } ?></b></td>
                <td  width="125" rowspan="3" align="right" valign="top"><?php
					if($my_orders['status']=='Pending'){
					  echo "<img style='padding-right:6px; margin-bottom: -10px;' src='images/pending.png'>";
					}
					if($my_orders['status']=='Shipped'){
					  echo "<img style='padding-right:6px; margin-bottom: -10px;' src='images/shipped.png'>";
					}
					if($my_orders['status']=='Delivered'){
					  echo "<img style='padding-right:6px; margin-bottom: -10px;' src='images/delivered.png'>";
					}
					 echo "<b class=\"myodr_inner_imgtext\">".$my_orders['status']."</b>"?>
				<br /><br />
                <?php if($my_orders['tracking_url']!=''){ ?>
                <a class="myorders_a_link" target="_blank" href="<?=$my_orders['tracking_url']?>">Track your order</a>
                <?php  }else{ ?> 
                <!--<a class="myorders_a_link" style="cursor:pointer;" onclick="alert('Not Available');">Track your order</a>-->
				<?php }  ?>
                </td>
            </tr>
			<tr><td>Courier Name : <b><?php if($my_orders['courier_name']!=''){ echo $my_orders['courier_name']; }else{ echo 'N/A'; } ?></b></td></tr>
			<tr><td>Tracking Number : <b><?php if($my_orders['tracking_no']!=''){ echo $my_orders['tracking_no']; }else{ echo 'N/A'; } ?></b></td></tr>
			<!--<tr><td>
				<a class="myorders_a_link" target="_blank" href="<?=$my_orders['tracking_url']?>">Track your order</a>
				</td></tr>-->
		</table>
	</td>	
  </tr>
 
 <?php
	} // END OF WHILE
 ?>
 
 
</table>

<input style="margin-top: 20px;" class="back_btn" type="button" name="back" value="Back" onClick="history.back();" />
</center>
</div>


    
    
<?php include("footer.php"); ?>