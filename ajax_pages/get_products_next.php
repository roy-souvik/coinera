<?php
session_start();
include("../includes/config.php");
include("../includes/dbcon.php");

error_reporting(0);
?>
<style>
.border_select{
	border:3px solid #790000!important;
	border-radius:5px;
	box-shadow:3px 3px 1px rgba(60, 60, 60, 0.35)!important;
	padding:5px!important;
}
</style>
<script>
$(document).ready(function() {
	$('.phtGalLftdiv img').css('opacity','0.7').removeClass("border_select");
	$('.phtGalLftdiv img').mouseover(function() {
		$(this).fadeTo(100,1).addClass("border_select");
		$('.phtGalLftdiv img').not(this).removeClass("border_select").fadeTo(100,0.7);
	});
});
</script>
<?php
if(isset($_POST['product_type'])){
	$prdct_type=$_POST['product_type']; //exit; 
$post_per_page = 9;
$post_nos_shown=5;
$page_multiplier = (isset($_POST['names'])?$_POST['names']:1)-1; 
$post_begin_marker = $post_per_page*$page_multiplier;	


if(($_POST['product_type'])==1){
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
	$sql_querys=mysql_query("select * from product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']);
	$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */	
	$sql=mysql_query("SELECT * FROM product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']." limit $post_begin_marker,$post_per_page");
	
	}else{
		$sql_querys=mysql_query("select * from product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y'");
		$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */	
		$sql=mysql_query("SELECT * FROM product_info WHERE bid_price!=0 AND bid_status='Y' AND status='Y' limit $post_begin_marker,$post_per_page");
		
	}
}

else if(($_POST['product_type'])==2){
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
		
$sql_querys=mysql_query("select * from product_info WHERE direct_price!=0 AND status='Y' and user_id!=".$_SESSION['user_id']);
$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */
 $sql=mysql_query("SELECT * FROM product_info WHERE direct_price!=0 AND status='Y' and user_id!=".$_SESSION['user_id']." limit $post_begin_marker,$post_per_page");
 
	}else{
		$sql_querys=mysql_query("select * from product_info WHERE direct_price!=0 AND status='Y'");
$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */
		
		$sql=mysql_query("SELECT * FROM product_info WHERE direct_price!=0 AND status='Y' limit $post_begin_marker,$post_per_page");
	}
}

else{
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
		
	$sql_querys=mysql_query("select * from product_info WHERE bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']);
$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */	
 	$sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y' and user_id!=".$_SESSION['user_id']." limit $post_begin_marker,$post_per_page");
	}else{
		$sql_querys=mysql_query("select * from product_info WHERE bid_status='Y' AND status='Y'");
$post_nos=mysql_num_rows($sql_querys);
/*============================================================= */	
		$sql=mysql_query("SELECT * FROM product_info WHERE bid_status='Y' AND status='Y' limit $post_begin_marker,$post_per_page");
	}
}

 $row=mysql_num_rows($sql);
 
  if($row > 0){
	while($product=mysql_fetch_array($sql)){
		$prd_id=$product['id'];
		if($product['bid_price']!=0 && $product['direct_price']==0 ){
			$price=$product['bid_price'];
			$text="Bid";
			$flag=1;
			$url='product_details.php?product_id='.$product['id'].'&flag='.$flag;
			}else if($product['direct_price']!=0 && $product['bid_price']==0){
				$price=$product['direct_price'];
				$text="Add to Cart";
				$flag=2;
				
				if(!isset($_SESSION['user_name'])){
						$url='single_login.php';
						$_SESSION['login_page_url'] = 'product_gallery.php';
					}else{
						$url='cart.php?id='.$product['id'].'&action=add';
					}
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
                <p style="text-align:center; font-size:12px !important;">
                <?php
			   	if(strlen($product['title'])>15){
				$result=substr($product['title'],0,15);
					echo $result.'....';
				} else{ echo $product['title']; }
				?><br/>
                Regular Price: <font color="#ff0300">Rs. <?=$price?></font> 
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
<!--------------------------For Pagination------------------------------------>

		<?php
    	$total_page=ceil($post_nos/$post_per_page);
  			if($total_page<$post_nos_shown) {
			$post_nos_shown=$total_page;
		   	}
		   
		    $page_shown_head = floor($post_nos_shown/2);
			$page_shown_tail = ($post_nos_shown-$page_shown_head);
			
			 if((($page_multiplier+1)-$page_shown_head) <= 1){
				$pg_start = 1;
			  } elseif((($page_multiplier+1)+$page_shown_tail) > $total_page) {
				$pg_start = ($total_page-$post_nos_shown+1);
			  }else {
				$pg_start = (($page_multiplier+1)-$page_shown_head);
			  }
    	?>
        <?php if($post_nos > $post_per_page) { ?>
        <center> <div class="pagination">
        <?php if($page_multiplier != 0) { ?>
        
        <span class="pgbtn"><a class="page" name="<?=$prdct_type?>" value="1">First</a></span>
        
        <span class="pgbtn"><a class="page" name="<?=$prdct_type?>" value="<?=$page_multiplier?>">Prev</a></span>
        <?php } ?>
        
        
        <?php for($i=1,$page_no=$pg_start;$i<=$post_nos_shown;$i++,$page_no++) { ?>
        <?php if($page_no == $page_multiplier+1) { ?>
        <span class="pgbtn"><span class="selected"><?=$page_no?></span></span>
        <?php } else { ?>
        <span class="pgbtn"><a class="page" name="<?=$prdct_type?>" value="<?=$page_no?>"><?=$page_no?></a></span>
        <?php } ?>
        <?php } ?>
        
        
        <?php if($page_multiplier != ceil($post_nos/$post_per_page)-1) { ?>
        
        <span class="pgbtn"><a class="page" name="<?=$prdct_type?>" value="<?=$page_multiplier+2?>">Next</a></span>
        <span class="pgbtn"><a class="page" name="<?=$prdct_type?>" value="<?=ceil($post_nos/$post_per_page)?>">Last</a></span>
        
        <?php } ?>
        </div></center>
        <?php } ?>
        
        <!--------------------------End Pagination------------------------------------>

					<script type="text/javascript" src="js/nav2.js"></script>	