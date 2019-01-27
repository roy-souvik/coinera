<?php error_reporting(0); ?>
<?php include("header.php"); ?>

<?php /****paypal url*****/
	  $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';  
	  $sandbox_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	  
	 $item_msg='';
	 $cart_page=$_SERVER["REQUEST_URI"];
	 $_SESSION['login_page_url'] = $cart_page;
?>

 <div class="outerdiv_frame">
 <?php

	$product_id = $_GET['id'];	 //the product id from the URL 
	$action 	= $_GET['action']; //the action from the URL 
	
	
		//if there is an product_id and that product_id doesn't exist display an error message
		if($product_id && !productExists($product_id)) {
			$messege="<h1 class=\"not_found \">Sorry ! No Product Found</h1>";
			echo $messege;
			?></div><?php
			include("footer.php");
			exit;
		}

	switch($action) {	//decide what to do	
	
		case "add":
			 
			$_SESSION['cart'][$product_id]++; //add one to the quantity of the product with id $product_id 
			
			$sql_add = mysql_query(sprintf("SELECT title FROM product_info WHERE bid_price='0' AND id =%d;",$product_id)); 
			list($title) = mysql_fetch_row($sql_add);
			$item_msg='<span style="color:green;"><img src="images/success.gif" style="margin-top: 3px; margin-bottom: -3px;">&nbsp;&nbsp;'.$title.' was added to Your Shopping Cart.</span>';
			
			if($_SESSION['cart'][$product_id] > 1){
				$_SESSION['cart'][$product_id]--;
				
				$sql_exit = mysql_query(sprintf("SELECT title FROM product_info WHERE bid_price='0' AND id =%d;",$product_id)); 
				list($title) = mysql_fetch_row($sql_exit);
				$item_msg='<span style="color:red;"><img src="images/removed.png" style="margin-top: 3px; margin-bottom: -3px;">&nbsp;&nbsp;'.$title.' is already in Your shopping Cart.</span>';
				
				if($_SESSION['cart'][$product_id] == 0)
					unset($_SESSION['cart'][$product_id]);
			}
		break;
		
		case "remove":
			
			$_SESSION['cart'][$product_id]--; //remove one from the quantity of the product with id $product_id 
			$sql_remove = mysql_query(sprintf("SELECT title FROM product_info WHERE bid_price='0' AND id =%d;",$product_id)); 
			list($title) = mysql_fetch_row($sql_remove);
			$item_msg='<span style="color:red;"><img src="images/del.png" style="margin-top: 3px; margin-bottom: -3px;">&nbsp;&nbsp;'.$title.' was removed from Your shopping Cart.</span>';
			if($_SESSION['cart'][$product_id] == 0) unset($_SESSION['cart'][$product_id]); //if the quantity is zero, remove it completely (using the 'unset' function) - otherwise is will show zero, then -1, -2 etc when the user keeps removing items. 
		break;
		
		case "empty":
			unset($_SESSION['cart']); //unset the whole cart, i.e. empty the cart. 
		break;
	
	}
	
?>


	<?php	
        if($_SESSION['cart']) {	//if the cart isn't empty
            //show the cart
    
		 if($_SESSION['item_msg']!=''){ ?>
         <center>
            <div class="validation_message"><?=$_SESSION['item_msg']?></div>
         </center>
      	<?php $_SESSION['item_msg']='';}?>
        <div class="cart_pass_box">
        
		<table width="100%" cellspacing="0" cellpadding="10" border="1" padding="3">	
		<tr class="cart_pro_title_tr" style="font-size: 14px;"> 
        	<td width="40" align="center">SL No</td>
            <td width="140" align="center">Product Image</td>
			<td width="420" align="center">Product Name</td>
            <td width="60" align="center">Quantity</td>
            <td width="70" align="center">Cost</td>
            <td></td>
		</tr>
		<?php
			$sl_no=1;
			//iterate through the cart, the $product_id is the key and $quantity is the value
			foreach($_SESSION['cart'] as $product_id => $quantity) {	
			
				//get the title, image and price from the database - this will depend on your database implementation.
				//use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
				$sql = sprintf("SELECT title, images, direct_price FROM product_info WHERE bid_price='0' AND id = %d;",$product_id); 
				$result = mysql_query($sql);
				//Only display the row if there is a product (though there should always be as we have already checked)
				if(mysql_num_rows($result) > 0) {
					
					list($title, $image, $direct_price) = mysql_fetch_row($result);
				
					$line_cost = $direct_price * $quantity;		//work out the line cost
					$total = $total + $line_cost;			//add to the total cost
					$total = $total+($total/100);
					$total = sprintf ("%.2f", $total);
		?>
					<tr class="cart_products_tr">
                    	<td align="center"><?=$sl_no++?></td>
                        <td align="center"><img class="nice_img" border="0" src="ProductImage/thumbs/<?=$image?>" width="70" height="70" /></td>
                    	<td align="center"><?=$title?></td>
						<td align="center"><?=$quantity?></td>
						<td align="center">$ <?=$line_cost?></td>
                        <td align="center"><a href="<?=$_SERVER['PHP_SELF']?>?action=remove&id=<?=$product_id?>"><img width="18px" height="18px" src="images/2.png" title="Delete Product"></a></td>
					</tr>
		<?php 
				}
			} 
			$_SESSION['sl_no']=($sl_no-1);
		?>
            
			<tr class="cart_pro_total_tr">
				<td colspan="4" align="right">Total</td>
				<td colspan="2" align="right">$ <?=$total?></td>
			</tr>
			<!--<tr bgcolor="#FFFFD5">--><tr class="cart_pro_title_tr">
				<td colspan="6" align="right">
               <!-- <a style="float:left;" class="crt_a_link" href="product_gallery.php">Continue Shopping</a>-->
                <a style="float:right;margin-left: -195px; margin-right: 108px;" class="crt_a_link" href="<?=$_SERVER['PHP_SELF']?>?action=empty" onclick="return confirm('Are you sure?');">Empty Cart</a>
                <!--</td>
			</tr>
			<tr bgcolor="#F3E4B9">
                <td colspan="6" align="right">-->
                
                <!----------------------Paypal Start----------------------->
                <?php /*if($_SESSION['user_name']!=''){ $url='index.php' ;} else{ $url='single_login.php';}*/?>
                <?php if($_SESSION['user_name']!=''){$url=$sandbox_url ;} else{ $url='single_login.php';}?> <!----- sandbox url------->
                <?php /*if($_SESSION['user_name']!=''){$url=$paypal_url ;} else{ $url='single_login.php';}*/?> <!------- paypal url------>
                
                    <form action="<?=$url?>" method="post" name="paypal" >
                        <input name="amount" type="hidden" id="amount"   value="<?=$total?>">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="bibhas.m@arhamcreation.com">
                        <input type="hidden" name="item_name" value="Items">
                        <input type="hidden" name="return" value="http://<?=$_SERVER['HTTP_HOST']?>/coinera/payment_success.php" />
                        <input type="hidden" name="cancel_return" value="http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>">
                        <input type="hidden" name="notify_url" value="http://<?=$_SERVER['HTTP_HOST']?>/coinera/" />
                        <input type="hidden" name="rm" value="1">
                        <input type="hidden" name="quantity" value="1"> 
                        <input type="hidden" name="no_note" value="1">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="submit" name="Submit" value="Check Out" class="cart_checkout_btn" style="float:right;">
                    </form>
                
                 <!---------------------Paypal End------------------------>
                 </td>
			</tr>		
		</table>
        </div>
		
	<?php
        }else{
            echo "<h1 class=\"not_found conti_shop_h1\">You have no items in your shopping cart.</h1>";
        }
        
        //function to check if a product exists
        function productExists($product_id) {
            //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
            $sql = sprintf("SELECT * FROM product_info WHERE id = %d;",$product_id); 
            return mysql_num_rows(mysql_query($sql)) > 0;
        }
    ?>
    	<a class="crt_a_link continue_shopping" href="product_gallery.php">Continue Shopping</a>
        
    </div>
    
	<?php
    if(isset($_GET['action']) && !empty($_GET['action'])) {
		$_SESSION['item_msg']=$item_msg;
        header('location:cart.php');	
    }
    ?>


<?php include("footer.php"); ?>