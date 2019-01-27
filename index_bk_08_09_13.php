<?php include("header.php"); ?>

<script type="text/javascript">
function showsab(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	//document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax_pages/get_sab.php?q="+str,true);
xmlhttp.send();
}
</script>



<script type="text/javascript">
function showprdt(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint1").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax_pages/get_prdt.php?q="+str,true);
xmlhttp.send();
}
</script>

























<div class="body_cont">
    	<div class="banner">
            <div class="banner_frame"><img src="images/main_banner.jpg" /></div>
        </div>
        
      <?php if($_SESSION['active_msg']!=''){ ?>
         <center id="active_msg">
            <div class="validation_message"><?=$_SESSION['active_msg']?></div>
         </center>
      <?php unset($_SESSION['active_msg']);}?>
        
        <div class="auction_product">
        <img src="images/auction_product_bg.png" />
        AUCTION PRODUCTS
        </div>
        
        
                    
            
            
            
            
            <div class="pdtt_glry_select" style="margin-left:20px; float:left;">
                   
                Sort By : <select name="cat_type" class="product_type" onchange="showsab(this.value)">
                <option value="">---SELECT---</option>
                <?php
				
				$cat_sql="SELECT * FROM `category_info` WHERE `p_id` =0 AND status='Y'";
				$fetch_cat=mysql_query($cat_sql);
				while($rec_cat=mysql_fetch_array($fetch_cat))
	             {	
				 
				?>
                    
                    <option value="<?=$rec_cat['id']?>"><?=$rec_cat['name']?></option>
                   <?php
				   
				   }
				   ?>
                </select>
                
               </div>
            
            <div id="txtHint" style="float:left;">
            
            </div>
            
            
            
        <div class="body_content">
        <div class="outerdiv_frame" id="txtHint1">
        
         <?php
		 
	$fetch_prdt=mysql_query("SELECT *FROM `product_info` WHERE `status`='Y' AND `bid_status`='Y' ORDER BY `product_info`.`id` DESC LIMIT 0 , 6");
	$row=mysql_num_rows($fetch_prdt);
 
  if($row > 0){
	 while($rec_prdt=mysql_fetch_array($fetch_prdt))
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
                            <p>
                Name : <?php
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
		  }
		   }
		  else{
		echo "<span class='opps_sorry'>Opps! Sorry No Product Found.</span>";
		}
		  ?>       
                 

             </div>
        </div>
    </div>
    
    
<?php include("footer.php"); ?>