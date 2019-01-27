<?php
error_reporting(0);
$cat_id=$_POST['id'];
include("../includes/config.php");
include("../includes/dbcon.php");
?>
<span class="txtHint1_a">

<?php
if($_POST['id']){
	
	$Date = date("Y-m-d");	
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
		$product_sql=mysql_query("SELECT * FROM product_info WHERE `product_info`.`cat_id`='".$cat_id."' AND '".$Date."'>=start_date AND  '".$Date."'<=end_date AND bid_status='Y' AND status='Y' AND user_id!=".$_SESSION['user_id']." ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
	}else{
		$product_sql=mysql_query("SELECT * FROM product_info WHERE `product_info`.`cat_id`='".$cat_id."' AND '".$Date."'>=start_date and  '".$Date."'<=end_date and bid_status='Y' AND status='Y'ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
	}
	
	$num_rows = mysql_num_rows($product_sql);
	if($num_rows!=0)
	 {
	 while($rec_prdt=mysql_fetch_array($product_sql))
	{		
  if($rec_prdt['bid_price']!=0 && $rec_prdt['direct_price']==0 ){
			$price=$rec_prdt['bid_price'];
			$flag=1;
			$text="Bid";
			$url='product_details.php?product_id='.$rec_prdt['id'].'&flag='.$flag;
			}else if($rec_prdt['direct_price']!=0 && $rec_prdt['bid_price']==0){
				$price=$rec_prdt['direct_price'];
				$text="Add to Cart";
				$flag=2;
				
				if(!isset($_SESSION['user_name'])){
						$url='single_login.php';
						$_SESSION['login_page_url'] = 'index.php';
					}else{
						$url='cart.php?id='.$rec_prdt['id'].'&action=add';
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
                        <a href="product_details.php?product_id=<?=$rec_prdt['id']?>&flag=<?=$flag?>">
                          <img src="ProductImage/thumbs/<?=$rec_prdt['images']?>">
                        </a>
                        </div></div>
                         
                        <div class="phtGalLftdivT">  
                        <p style="text-align:center; font-size:12px !important;">
							<?php
                            if(strlen($rec_prdt['title'])>15){
                            $result=substr($rec_prdt['title'],0,15);
                                echo $result.'....';
                            } else{ echo $rec_prdt['title']; }
                            ?><br/>
                            Regular Price: <font color="#ff0300">Rs. <?=$price?></font> 
						</p>
                        
                         
                 <a href="<?=$url?>"><?=$text?> </a>
                        </div>
                 </div>
  
  <?php
     }//end while
  }
else
   {
   ?>
<div class='opps_sorry'> No records found </div>
 <?php  
   }//end if
 } //end if
?> 

</span>