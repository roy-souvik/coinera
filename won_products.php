<?php include("header.php"); ?>

<?php
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}
?>
<div class="outerdiv_frame">

<?php 
$user_id = $_SESSION['user_id'];
//echo "SELECT * FROM `product_status` WHERE winner_id=".$user_id;
$sql=mysql_query("SELECT * FROM `product_status` WHERE winner_id=".$user_id);

 
if(mysql_num_rows($sql) == 0){
	
	echo"<center><H1>You have not won any items</H1></center>";
 }

else{

	while($product=mysql_fetch_array($sql)){
		
	$product_details=mysql_fetch_array(mysql_query("SELECT title,images FROM `product_info` WHERE id=".$product['product_id']));
	$product_price=mysql_fetch_array(mysql_query("SELECT final_bid_price FROM `bid_info` WHERE product_id=".$product['product_id']));

?>		<div class="outerdiv">
	        <div class="phtGalLftdiv"><div>	
                  <img src="ProductImage/thumbs/<?=$product_details['images']?>">
            </div></div>
            <div class="phtGalLftdivT">  
                <p>
                Name : <?=$product_details['title']?> <br/>
                Final bid Price: <font color="#ff0300">Rs. <?=$product_price['final_bid_price'];?></font> 
                </p>
                <div class="editproduct">
<?php 
	$ordr_status=mysql_num_rows(mysql_query("SELECT * FROM `product_status` WHERE product_id=".$product['product_id']." and order_no!='' and `winner_id`=".$user_id));
				if($ordr_status!=0){ ?>
					<a href="my_orders.php">Status</a>
                <?php
				}else{ 
					$url=mysql_fetch_array(mysql_query("select url from admin_master where admin_id=1"));
				?>
                <a href="<?=$url['url']?>winning_item.php?product_id=<?=$product['product_id']?>">Pay</a>
                <?php
				}
				?>
				</div>
            </div>
		</div>	
<?php	
	} // END OF WHILE LOOP
} // END OF ELSE
?> 
</div>


<?php include("footer.php"); ?>