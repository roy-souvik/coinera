<?php include("header.php"); ?>

<?php
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}
?>
<div class="outerdiv_frame">

<?php 
$user_id = $_SESSION['user_id'];

$sql=mysql_query("SELECT * FROM `bid_info` WHERE user_id=".$user_id);

 
if(mysql_num_rows($sql) == 0){
	
	echo"<center><H1>You have currently no bid items</H1></center>";
 }

else{

	while($product=mysql_fetch_array($sql)){
		
	$product_details=mysql_fetch_array(mysql_query("SELECT title,images FROM `product_info` WHERE id=".$product['product_id']));
	$won_sql=mysql_query("SELECT * FROM `product_status` WHERE product_id=".$product['product_id']." and `winner_id`=".$user_id);
	$won_status=mysql_num_rows($won_sql);
	$won_res=mysql_fetch_array($won_sql);
	
?>		<div class="outerdiv">
	        <div class="phtGalLftdiv"><div>	
                  <img src="ProductImage/thumbs/<?=$product_details['images']?>">
            </div></div>
            <div class="phtGalLftdivT">  
                <p>
                Name : <?php if(strlen($product_details['title'])>15){
							$result=substr($product_details['title'],0,15);
							echo $result.'....';
							}
						else { echo $product_details['title']; }
				?> <br/>
                <?php
				if($won_res['order_no']!=''){ ?>
                Purchased Price: 
                <?php }else{ ?>
                Regular Price: 
                <?php } ?>
                <font color="#ff0300">Rs. <?=$product['final_bid_price'];?></font> 
                </p>
                <div class="editproduct">
                <?php
				if($won_status!=0){ 
					if($won_res['order_no']!=''){ ?>
                	Purchased
                <?php }else{ ?>
                	Won
                <?php
					}
				}else{ ?>
                <a href="product_details.php?product_id=<?=$product['product_id']?>&flag=1">Edit</a>
                 <?php } ?>
                </div>
            </div>
		</div>	
<?php	
	} // END OF WHILE LOOP

} // END OF ELSE
?> 
</div>


<?php include("footer.php"); ?>