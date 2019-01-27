<?php
error_reporting(0);
$parent_id=$_POST['id'];
include("../includes/config.php");
include("../includes/dbcon.php");
?> 

<?php if($parent_id!=''){?>
	<span class="txtHint_a">
		<div class="pdtt_glry_select">
            <select name="cat_type" class="txtHint">
                <option selected="selected" value="">---SELECT---</option>
                <?php
				$sub_cat_sql="SELECT * FROM `category_info` WHERE `p_id`=".$parent_id." AND status='Y'";
				$fetch_cat_sub=mysql_query($sub_cat_sql);
				while($sub_cat_details=mysql_fetch_array($fetch_cat_sub)){	
				?>
                    <option value="<?=$sub_cat_details['id']?>"><?=$sub_cat_details['name']?></option>
                <?php }?>
            </select>
         </div>
        <span class="txtHint_b">
     
            <div class="body_content">
            
				<?php  
				  	$Date = date("Y-m-d");	
					if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
						$product_sql=mysql_query("SELECT * FROM product_info WHERE `cat_p_id`=".$parent_id." AND '".$Date."'>=start_date AND  '".$Date."'<=end_date AND bid_status='Y' AND status='Y' AND user_id!=".$_SESSION['user_id']." ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
					}else{
						$product_sql=mysql_query("SELECT * FROM product_info WHERE `cat_p_id`=".$parent_id." AND '".$Date."'>=start_date AND  '".$Date."'<=end_date AND bid_status='Y' AND status='Y' ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
					}
				 
				 	$row=mysql_num_rows($product_sql);
					 if($row > 0){
					 while($product_details=mysql_fetch_array($product_sql)){
					  if($product_details['bid_price']!=0 && $product_details['direct_price']==0 ){
							$price=$product_details['bid_price'];
							$flag=1;
							$text="Bid";
							$url='product_details.php?product_id='.$product_details['id'].'&flag='.$flag;
					  }else if($product_details['direct_price']!=0 && $product_details['bid_price']==0){
							$price=$product_details['direct_price'];
							$text="Add to Cart";
							$flag=2;
								
								if(!isset($_SESSION['user_name'])){
										$url='single_login.php';
										$_SESSION['login_page_url'] = 'index.php';
									}else{
										$url='cart.php?id='.$product_details['id'].'&action=add';
									}
					}else{ ?>
						<div class="outerdiv">
							<span style='color:red;'>There Might Be Some Problem.</span>
						</div>
					<?php }?>			
				  
				
								<div class="outerdiv">
								
									<div class="phtGalLftdiv">
									  <div>
										<a href="product_details.php?product_id=<?=$product_details['id']?>&flag=<?=$flag?>">
										  <img src="ProductImage/thumbs/<?=$product_details['images']?>">
										</a>
									  </div>
									</div>
										
									<div class="phtGalLftdivT">  
									  <p style="text-align:center; font-size:12px !important;">
										<?php
										if(strlen($product_details['title'])>15){
										$result=substr($product_details['title'],0,15);
											echo $result.'....';
										} else{ echo $product_details['title']; }
										?><br/>
										Regular Price: <font color="#ff0300">Rs. <?=$price?></font> 
									  </p>
								
									  <a href="<?=$url?>"><?=$text?> </a>
									</div>
									
								 </div>
				 <?php
					   }//end while
					 }else{ ?>
                    <div class='opps_sorry'> No records found </div>
                  <?php  }//end if
				  ?>
		</div> 	
        
       </span>
    </span>
    <?php 
     }else{
    ?>
	 
     <div class="outerdiv_frame">
        
    <?php
	$Date = date("Y-m-d");	
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!=''){
		$product_sql=mysql_query("SELECT * FROM product_info WHERE '".$Date."'>=start_date AND  '".$Date."'<=end_date AND bid_status='Y' AND status='Y' AND user_id!=".$_SESSION['user_id']." ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
	}else{
		$product_sql=mysql_query("SELECT * FROM product_info WHERE '".$Date."'>=start_date and  '".$Date."'<=end_date and bid_status='Y' AND status='Y'ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
	}
	
	$row=mysql_num_rows($product_sql);
 
  if($row > 0){
	 while($product_details=mysql_fetch_array($product_sql)){
		 
	  if($product_details['bid_price']!=0 && $product_details['direct_price']==0 ){
			$price=$product_details['bid_price'];
			$flag=1;
			$text="Bid";
			$url='product_details.php?product_id='.$product_details['id'].'&flag='.$flag;
	  }else if($product_details['direct_price']!=0 && $product_details['bid_price']==0){
			$price=$product_details['direct_price'];
			$text="Add to Cart";
			$flag=2;
				
				if(!isset($_SESSION['user_name'])){
						$url='single_login.php';
						$_SESSION['login_page_url'] = 'index.php';
					}else{
						$url='cart.php?id='.$product_details['id'].'&action=add';
					}
	}else{ ?>
        <div class="outerdiv">
            <span style='color:red;'>There Might Be Some Problem.</span>
        </div>
	<?php }?>			
  

                <div class="outerdiv">
                
                    <div class="phtGalLftdiv">
                      <div>
                        <a href="product_details.php?product_id=<?=$product_details['id']?>&flag=<?=$flag?>">
                          <img src="ProductImage/thumbs/<?=$product_details['images']?>">
                        </a>
                      </div>
                    </div>
                        
                    <div class="phtGalLftdivT">  
                      <p style="text-align:center; font-size:12px !important;">
						<?php
                        if(strlen($product_details['title'])>15){
                        $result=substr($product_details['title'],0,15);
                            echo $result.'....';
                        } else{ echo $product_details['title']; }
                        ?><br/>
                        Regular Price: <font color="#ff0300">Rs. <?=$price?></font> 
                      </p>
                
                 	  <a href="<?=$url?>"><?=$text?> </a>
                    </div>
                    
                 </div>
 <?php
       }//end while
     }
      else{ ?>
        <div class='opps_sorry'> No records found </div>
    <?php
     }//end if
 ?>       

          </div>
     
<?php	 
} //end if
  ?>      