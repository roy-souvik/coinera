<?php include("header.php"); ?>

<?php
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}
?>
<style>
/*.winner_btn {
	margin-left:-30px;
	background:url(images/star2.png) 0px -24px no-repeat;
	display: inline-block;
    height: 24px;
    width: 24px;
}
.winner_btn:hover{
	margin-left:-30px;
	background:url(images/star2.png) no-repeat;
	display: inline-block;
    height: 24px;
    width: 24px;
}*/
.winner_btn {
	margin-left:-40px;
	background:url(images/star.png) no-repeat;
	display: inline-block;
    height: 40px;
    width: 40px;
}
.winner_btn:hover{
	margin-left:-40px;
	background:url(images/star.png) 0px -40px no-repeat;
	display: inline-block;
    height: 40px;
    width: 40px;
	text-decoration:none;
}
.winner_btn span{
	line-height:40px;
	color:#FFF;
	font-weight:800;
}
.winner_btn:hover span{
	color:#000;
}
</style>
<div class="outerdiv_frame">
<?php
if(isset($_GET['run_func'])){
if ($_GET['run_func'] != '') {
    myFunction($_GET['run_func']);
}
}
function myFunction($id) 
{
    $_SESSION['pid']=$id;
	//header("location:edit_products.php");
	echo "<script type='text/javascript'>window.location = 'edit_products.php'</script>";

}  
?>

<?php 
$user_id = $_SESSION['user_id'];

//$cat_id=$_REQUEST['cat_id'];
 $cat_id=1;
 //echo "SELECT * FROM product_info WHERE user_id=".$user_id." AND bid_status='Y' AND status='Y'";
 $sql=mysql_query("SELECT * FROM product_info WHERE user_id=".$user_id." AND bid_status='Y' AND status='Y'");
  //$sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y' AND cat_id=".$cat_id);
 $row=mysql_num_rows($sql);
 
if($row > 0){
	while($product=mysql_fetch_array($sql)){

		if($product['bid_price']!=0 ){
			$price=$product['bid_price'];
			$text="<img style=\"margin-top:3px;\" src='images/bid.png'>";
			$flag=1;
			}else if($product['direct_price']!=0 ){
				$price=$product['direct_price'];
				$text="<img style=\"margin-top:3px;width:16:px;height:16px;\" src='images/cart.png'>";
				$flag=2;
			}else{
			?>
            <div class="outerdiv">
                <span style='color:red;'>There Might Be Some Problem.</span>
            </div>
			<?php
			}
			?>
		<div class="outerdiv">
<?php
		$COUNT_BID=mysql_num_rows(mysql_query("SELECT `product_id` FROM `bid_info` WHERE `product_id`=".$product['id']));
		if($COUNT_BID>0){
?>		
		<a title="Make Winner" class="winner_btn" href="make_winner.php?prod_id=<?=$product['id']?>"><span><?=$COUNT_BID?></span></a> 
<?php
	   }
?>		
            <div class="phtGalLftdiv"><div>
			
                <a href="product_details.php?product_id=<?=$product['id']?>&flag=<?=$flag?>">
                  <img src="ProductImage/thumbs/<?=$product['images']?>">
                </a>
            </div></div>
            <div class="phtGalLftdivT">  
                 <p style="text-align:center; font-size:12px !important;">
               <?php
			   	if(strlen($product['title'])>15){
				$result=substr($product['title'],0,15);
					echo $result.'....';
				} else{ echo $product['title']; }
				?><br/>
                Regular Price: <font color="#ff0300">Rs. <?=$price?></font> 
                </p>
                <div class="editproduct">
                <?=$text?>&nbsp;|
                <a href="personal_product_gallery.php?run_func=<?=$product['id']?>">Edit</a></div>
            </div>
        </div>
   <?php
		}
	}else{
		echo "<H1 class='not_found'>Opps! Sorry No Product Found.</H1>";
		}
	?>
</div>


<?php include("footer.php"); ?>