<?php
error_reporting(0);
 $sab_id=$_GET["q"];
include("..//includes/config.php");
include("../includes/dbcon.php");


?> 


<div class="pdtt_glry_select">
            <select name="cat_type" class="product_type" onchange="showprdt(this.value)">
                <option value="">---SELECT---</option>
                <?php
				
				$sab_cat_sql="SELECT * FROM `category_info` WHERE `p_id`=$sab_id AND status='Y'";
				$fetch_cat_sab=mysql_query($sab_cat_sql);
				while($rec_cat_sab=mysql_fetch_array($fetch_cat_sab))
	             {	
				?>
                    
                    <option value="<?=$rec_cat_sab['id']?>"><?=$rec_cat_sab['name']?></option>
                   <?php
				   
				   }
				   ?>
                </select>
            </div>
            
            
     
            
            
            
            
            
            