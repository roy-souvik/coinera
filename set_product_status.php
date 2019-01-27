<?php include("header.php"); ?>

<?php
if(!isset($_SESSION['user_name']) && !isset($_SESSION['user_id'])){
	header('Location:index.php');
}
?>
<link type="text/css" href="css/ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
<div class="outerdiv_frame">

 <div style="display:none;" class="validation_message"></div>
 
<?php
//echo "SELECT id FROM `product_info` WHERE user_id=".$_SESSION['user_id']." AND bid_status='N' AND status='N'";
$products_id_sql=mysql_query("SELECT id FROM `product_info` WHERE user_id=".$_SESSION['user_id']." AND bid_status='N' AND status='N'");
 
	if(mysql_num_rows($products_id_sql)==0){
		
		echo"<center class=\"validation_message\"><h1>Sorry no products found</h1></center>";
	}
     
	 else{
		while($products_id=mysql_fetch_array($products_id_sql))  {
		
		//echo "SELECT * FROM product_status WHERE product_id=".$products_id['id'];
	
		$products_sql=mysql_query("SELECT * FROM product_status WHERE product_id=".$products_id['id']);
		
		while($product=mysql_fetch_array($products_sql)){
		
		//if(strlen($product['title'])!=0 || strlen($product['title'])!=0)
	$SQL1=mysql_fetch_array(mysql_query("SELECT images,title FROM `product_info` WHERE id=".$products_id['id']));
//echo	$SQL2="SELECT final_bid_price FROM `bid_info` WHERE product_id=".$products_id['id'];	
?>		
			<div class="phtGalLftdiv">
				<div>
			       <img src="ProductImage/thumbs/<?=$SQL1['images']?>">
                 </div>
			</div>
			
            <div class="phtGalLftdivT">  
                <p>
					Name : <?=$SQL1['title']?> <br/>
			<?php
				if(strlen($product['courier_name'])!=0 || strlen($product['tracking_no'])!=0) {
				
				  $text_show="Edit Details";
					echo "Courier Name : ".$product['courier_name']."<br>";
					echo "Tracking Number : ".$product['tracking_no']."<br>";
					echo "Status : ".$product['status']."<br>";
					
				}//end of if
				else{ $text_show="Add Details";  }
			?>	   
                </p>
				<p style="cursor:pointer;" class="add_details<?=$products_id['id']?>" id="add_details<?=$products_id['id']?>"><?=$text_show?></p>
            </div>	
	
<table id="status_table<?=$products_id['id']?>" style="padding:5px;margin-top:5px;background:rgba(231, 219, 193,0.5);border:1px solid #888;border-radius:5px;box-shadow: 0 1px 1px 0 #686868;">
<?php
	$orderdate = explode('-', $product['delivery_date']);
	$month = $orderdate[1];
	$day   = $orderdate[2];
	$year  = $orderdate[0];
	
	$Delivery_Date=$day."-".$month."-".$year;
?>
	<tr><td><b>Delivery Date</b></td><td>:</td><td><input type="text" value="<?=$Delivery_Date?>" name="delivery_date" id="delivery_date<?=$products_id['id']?>"></td></tr>
	<tr><td><b>Courier Name</b></td><td>:</td><td><input type="text" value="<?=$product['courier_name']?>" name="courier_name" id="courier_name<?=$products_id['id']?>"></td></tr>
	<tr><td><b>Tracking Number</b></td><td>:</td><td><input type="text" value="<?=$product['tracking_no']?>" name="tracking_no" id="tracking_no<?=$products_id['id']?>"></td></tr>
	<tr><td><b>Tracking URL</b></td><td>:</td><td><input type="text" value="<?=$product['tracking_url']?>" name="tracking_url" id="tracking_url<?=$products_id['id']?>"></td></tr>
	<tr><td><b>Status</b></td><td>:</td>
										<td>
											<select name="status" id="status<?=$products_id['id']?>">
<option value="Pending"<?=($product['status']=='Pending')?'selected="selected"':''?>>Pending</option>
											  <option value="Shipped"<?=($product['status']=='Shipped')?'selected="selected"':''?>>Shipped</option>
											  <option value="Delivered"<?=($product['status']=='Delivered')?'selected="selected"':''?>>Delivered</option>
											</select>
										</td>
	</tr>	
	
	
	<tr><td><input type="submit" class="submit_status<?=$products_id['id']?>" name="submit_status<?=$products_id['id']?>" id="<?=$products_id['id']?>" value="SAVE"></td></tr>
</table>	
<script language="JavaScript">
$(document).ready( function() {
/* ----------------------------------*/
	$( "#delivery_date<?=$products_id['id']?>" ).datepicker({
		dateFormat: 'dd-mm-yy',
		constrainInput: true,
		minDate: 0,
	});
/* ----------------------------------*/	

$('#status_table<?=$products_id['id']?>').hide();

 $('#add_details<?=$products_id['id']?>').click(function(){

   $('#status_table<?=$products_id['id']?>').fadeToggle('normal');

 });
 
/* ----------------------------------*/

   $('.submit_status<?=$products_id['id']?>').click(function(){ 
   
   var id=$(this).attr('id');
   var delivery_date=$('#delivery_date<?=$products_id['id']?>').val();
   var courier_name=$('#courier_name<?=$products_id['id']?>').val();
   var tracking_no=$('#tracking_no<?=$products_id['id']?>').val();
   var tracking_url=$('#tracking_url<?=$products_id['id']?>').val();	
   var status=$('#status<?=$products_id['id']?>').val();	
   var flag=1;
   
   if(delivery_date=='00-00-0000'){
     
     alert('Enter a delivery date');
	 flag=0;
   }
   
   if(courier_name==''){
     
     alert('Enter a courier name');
	 flag=0;
   }
   
   if(tracking_no==''){
     
     alert('Enter a tracking number');
	 flag=0;
   }
   if(flag==1 && status=='Pending'){
     
     alert('Select Status');
	 flag=0;
   }
   
   if(status=='Delivered'){
     var mail_admin=1;
   }
   
  if(flag==1){ 
  
	   $.post('ajax_pages/product_status.php',{product_id:id,delivery_date:delivery_date,courier_name:courier_name,
				tracking_no:tracking_no,tracking_url:tracking_url,status:status},function(data){
			
					$('.validation_message').hide().fadeIn('normal').html(data);
          }); 
		  
		  
		$('#status_table<?=$products_id['id']?>').delay(500).fadeOut();  
		
				
   }// END OF IF CONDITION
	
  }); 
 
 
 //$('.validation_message').delay(1000).css('display','none');  
 
 
});// END OF DOCUMENT.READY()


</script>			
<?php		
		}//end of inner while		
	} //end of outer while
 }//end of else 			
?>


<br clear="all"/>

	
<!--   -->
	

<!--   -->
</div>


<?php include("footer.php"); ?>