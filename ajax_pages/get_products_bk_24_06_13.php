<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

error_reporting(0);


if(isset($_POST['product_type'])){

if(($_POST['product_type'])==1){
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
	$sql=mysql_query("SELECT * FROM product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']);
	}else{
		$sql=mysql_query("SELECT * FROM product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y'");
	}
}

else if(($_POST['product_type'])==2){
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
 $sql=mysql_query("SELECT * FROM product_info WHERE direct_price!=0 AND status='Y' and user_id!=".$_SESSION['user_id']);
	}else{
		$sql=mysql_query("SELECT * FROM product_info WHERE direct_price!=0 AND status='Y'");
	}
}

else{
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
 	$sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']);
	}else{
		$sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y'");
	}
}

 $row=mysql_num_rows($sql);
 
  if($row > 0){
	while($product=mysql_fetch_array($sql)){

		if($product['bid_price']!=0 && $product['direct_price']==0 ){
			$price=$product['bid_price'];
			$text="Bid";
			$flag=1;
			$url='product_details.php?product_id='.$product['id'].'&flag='.$flag;
			}else if($product['direct_price']!=0 && $product['bid_price']==0){
				$price=$product['direct_price'];
				$text="Add to Cart";
				$flag=2;
				$url='cart.php?id='.$product[id].'&action=add';
			}else{
			?>
            <div class="outerdiv">
                <span style='color:red;'>There Might Be Some Problem.</span>
            </div>
			<?php
			}
			?>
		<div class="outerdiv">
            <div class="phtGalLftdiv"><div>
                <a href="product_details.php?product_id=<?=$product['id']?>&flag=<?=$flag?>">
                  <img src="ProductImage/thumbs/<?=$product['images']?>">
                </a>
            </div></div>
            <div class="phtGalLftdivT">  
                <p style="text-align:center;">
                <?=$product['title']?><br/>
                Regular Price: <font color="#ff0300">$ <?=$price?></font> 
                </p>
                 <a href="<?=$url?>"><?=$text?> </a>
            </div>
        </div>
   <?php
		}
	}else{
		echo "<span class='opps_sorry'>Opps! Sorry No Product Found.</span>";
		}
}
?>