<?php error_reporting(0); ?>
<?php include("header.php"); ?>
<div class="outerdiv_frame">

<!--//////////////////////////////----Check Expiry Date----////////////////////////////////////-->
 

<?php
//echo $_SESSION['product_id'];
//echo $_SESSION['user_id'];
$Date = date("Y-m-d");
$sql_check=mysql_fetch_array(mysql_query("SELECT * FROM `product_status` WHERE product_id=".$_SESSION['product_id']." and `winner_id`=".$_SESSION['user_id']));
if($Date>$sql_check['expire_date']){
echo 'Your Purchase date is expired.';

}
else{

?> 


<?php /****paypal url*****/
	  $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';  
	  $sandbox_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	  
	  $bid_msg='';
	  $wining_item_page=$_SERVER["REQUEST_URI"];
	  $_SESSION['login_page_url'] = $wining_item_page;

  






?>



<!--//////////////////////////////----End Check Expiry Date----////////////////////////////////////-->






    
    <?php
    	 if($_SESSION['bid_msg']!=''){  unset($_SESSION['product_id']);?>
         <center>
            <div class="validation_message"><?=$_SESSION['bid_msg']?></div>
         </center>
     <?php }else{?>

	<table  border="0" padding="3" width="70%">	
		<tr> 
			<td align="center">Product Name</td>
			<td align="center">Product Image</td>
            <td align="center">Final Bid Price</td>
		</tr>
		<?php
			//use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
			$sql = sprintf("SELECT title, images FROM product_info WHERE id = %d;",$_SESSION['product_id']); 
			$result = mysql_query($sql);
				
			//Only display the row if there is a product (though there should always be as we have already checked)
			if(mysql_num_rows($result) > 0) {
				list($title, $image) = mysql_fetch_row($result);
				
				// final_bid_price
				$bids_price_query=mysql_fetch_array(mysql_query("SELECT final_bid_price FROM `bid_info` WHERE `product_id`=".$_SESSION['product_id']));
				$final_bid_price=round($bids_price_query['final_bid_price'], 2);
		?>
        <tr>
            <td align="center"><?=$title?></td>
            <td align="center"><img border="0" src="ProductImage/thumbs/<?=$image?>" width="50" height="50" /></td>
            <td align="center">Rs. <?=$final_bid_price?></td>
        </tr>
		<?php 
			}	
		?>
         <?php $final_bid_price_usd=currency("INR","USD",$final_bid_price); $final_bid_price_usd=round($final_bid_price_usd, 2)?>
         
              <!----------------------Paypal Start----------------------->
                
            <?php if($_SESSION['user_name']!=''){ $url=$sandbox_url ;} else{ $url='single_login.php';}?>
            <?php /*if($_SESSION['user_name']!=''){ $url=$paypal_url ;} else{ $url='single_login.php';}*/?>
               
            <form action="<?=$url?>" method="post" name="paypal" >
                <input name="amount" type="hidden" id="amount"  value="<?=$final_bid_price_usd?>">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="bibhas.m@arhamcreation.com">
                <input type="hidden" name="item_name" value="Items">
                <input type="hidden" name="return" value="http://arhamcreation.in/coinera/winner_payment_success.php" />
                <input type="hidden" name="cancel_return" value="http://localhost/coinera/">
                <input type="hidden" name="notify_url" value="http://localhost/coinera/" />
                <input type="hidden" name="rm" value="1">
                <input type="hidden" name="quantity" value="1"> 
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="currency_code" value="USD">
                <input type="submit" name="Submit" value="Pay">
            </form>
               
                <!---------------------Paypal End------------------------>
                 
			</tr>		
		</table>
		<?php }
		}?>
	<?php
        //function to check if a product exists
        function productExists($product_id) {
            //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
            $sql = sprintf("SELECT * FROM product_info WHERE id = %d;",$_SESSION['product_id']); 
            return mysql_num_rows(mysql_query($sql)) > 0;
        }
    
	
	//function to convert Rupee to dolar
	function currency($from_Currency,$to_Currency,$amount) {
			$amount = urlencode($amount);
			$from_Currency = urlencode($from_Currency);
			$to_Currency = urlencode($to_Currency);
			$url = "http://www.google.com/ig/calculator?hl=en&q=$amount$from_Currency=?$to_Currency";
			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			$rawdata = explode('"', $rawdata);
			$rate=$rawdata[3];
			$rate = explode(' U.S. dollars', $rate);
			return $rate[0];
		}
	
	
	
	?>

	
	<?php
    if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {
        $_SESSION['product_id']=$_GET['product_id'];
		$order_query=mysql_fetch_array(mysql_query("SELECT order_no FROM `product_status` WHERE product_id=".$_SESSION['product_id']));
		
		if($_SESSION['product_id'] && !productExists($_SESSION['product_id'])) {
		$bid_msg='<span style="color:red;"><img src="images/removed.png" style="margin-top: 3px; margin-bottom: -3px;">&nbsp;&nbsp;You have enter an Invalid link.</span>';
		}elseif(isset($order_query['order_no']) && !empty($order_query['order_no'])){
		$bid_msg='<span style="color:red;"><img src="images/removed.png" style="margin-top: 3px; margin-bottom: -3px;">&nbsp;&nbsp;You have enter an Invalid link.</span>';
		}else{
		$bid_msg='';	
			}
		$_SESSION['bid_msg']=$bid_msg;
        header('location:winning_item.php');	
    }
    ?></div>
<?php include("footer.php"); ?>