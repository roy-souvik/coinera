<?php
include("header.php");

if($_SESSION['user_name']==''){
	header('location:index.php');
}
?>



	<div class="outerdiv_frame">    
    
	<?php
	 if(isset($_SESSION['product_id'])){
		 
		$product_id=$_SESSION['product_id'];
		
		$sql=mysql_fetch_array(mysql_query("select * from user_info where id=".$_SESSION['user_id']));
		$sql1=mysql_fetch_array(mysql_query("select admin_mail,url from admin_master where admin_id=1"));
		$u_name=$sql['first_name'].' '.$sql['last_name'];
		$u_mail=$sql['email_id'];
		$u_phone=$sql['phone'];
		$u_street=$sql['address'];
		$u_city=$sql['city'].' - '.$sql['zip_code'];
		$u_state=$sql['state'];
		$u_country=$sql['country'];
		$admin_mail=$sql1['admin_mail'];
		$url=$sql1['url'];
		
		// final_bid_price
		$bids_price_query=mysql_fetch_array(mysql_query("SELECT final_bid_price FROM `bid_info` WHERE product_id=".$product_id." and  `user_id`=".$_SESSION['user_id']));
		$final_bid_price=round($bids_price_query['final_bid_price'], 2);
	
		
		//foreach($_SESSION['cart'] as $product_id => $quantity) {	
		
			$sql = "SELECT user_id, title, images FROM product_info WHERE id =".$product_id;
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0) {
					list($user_id, $title, $images) = mysql_fetch_array($result);
			
			//$line_cost = $final_bid_price;			//work out the line cost
			$total = $total + $final_bid_price;			//add to the total cost
			
			$output.='<tr height="80">';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;"><img src="'.$url.'ProductImage/thumbs/'.$images.'" width="70" height="70"></td>';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;">'.$title.'</td>';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;">Rs.'.$final_bid_price.'</td>';
			$output.='</tr>';
			
			
			/************Order No Start********************/
			
			$sql=mysql_query("SELECT id FROM `product_status` WHERE product_id=".$product_id);
			$sql_id=mysql_fetch_array($sql);
			$pro_status_id=$sql_id['id'];
			$time_date=date("Hdm");
			$order_no=$time_date.''.$pro_status_id;
			
			/************Order No End********************/
			
			/*************Seller Details**************/
			$seller_sql = mysql_fetch_array(mysql_query("SELECT * FROM user_info WHERE id =".$user_id));
			$seller_name=$seller_sql['first_name'].' '.$seller_email=$seller_email_id['last_name'];
			$seller_email=$seller_sql['email_id'];
			$seller_phone=$seller_sql['phone'];
			$seller_address=$seller_sql['address'];
			$seller_city=$seller_sql['city'].' - '.$seller_sql['zip_code'];
			$seller_country=$seller_sql['country'];
			$seller_address=$seller_sql['address'];
			
			}
		//}
		
		$output1.='<tr style="background-color:#C79F6A;">';
		$output1.= '<td align="right" colspan="4">Grand Total : <strong>Rs. '.$total.'</td>';
		$output1.='</tr>';
		
   
	
//------------------------------------Email code start here------------------------------------------------------
	
	/**********************************Mail Send To Buyer Start*****************************************/

	$emailto = $u_mail;
	$subject = "Bidding Product Info:";
	$headers = 'From: '.$admin_mail.''. "\r\n";
	$headers.= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$coinera_board_mailer.='
		<table width="85%" height="auto" style="border:1px solid #790000; background-color: rgba(255, 255, 213, 0.4); font-family:Arial, Helvetica, sans-serif; color:#3D1602; font-size:12px;">
			<tr>
				<th align="left" style="border-bottom:1px solid #790000;"><img src="'.$url.'images/coin_mail_logo.jpg" width="664"></th>
			</tr>
			<tr>
				<td align="left" style="padding:0 0 0 2px;">
					<p>Dear '.$u_name.',</p>
					<p>Thank you for dealing with us. Your product details are given below:</p>
				</td>
			</tr>
			
			<tr><td>&nbsp;</td></tr>
			 
			<tr>
				<td align="left" >
					<table align="center" width="660" style="border:1px solid #790000; border-collapse:collapse; background-color:rgba(255, 255, 213, 0.4);">
						<tr>
							<td align="center" colspan="5" style="background-color:#800000; color:#FFFFFF; font-size:16px; font-family:Trebuchet MS; padding:5px 0;">Product Details</td>
						</tr>
						<tr style="border:1px solid #790000; border-style:dotted; background-color:#C79F6A; font-size: 14px;">
							<td align="center" width="25%" style="border:1px solid #790000; border-style:dotted;">Product Image</td>
							<td align="center" width="55%" style="border:1px solid #790000; border-style:dotted;">Product Name</td>
							<td align="center" width="20%" style="border:1px solid #790000; border-style:dotted;">Price Rs. </td>
						</tr>	
				'.$output.'
				'.$output1.'
					</table>
				</td>
			</tr>
			
			<tr>
				<td><p>With regards ,</p><p style="font-weight:bold;">Coin Era Team</p></td>
			</tr>
			<tr>
				<td align="center" style="color:#FFFFFF; background:#3D1602;">Copyright &copy; '.date('Y').' Coin Era</td>
			</tr>
		</table>';


	   $m_send=@mail($emailto, $subject, $coinera_board_mailer, $headers);
	   
	   /*******************************Mail Send To Buyer End**********************************/
	   
	   
	   /*******************************Mail Send To admin Start*************************************/
	   
			$emailto1 = $admin_mail;
			$subject1 = "Buyers Bidding Product Info:";
			$headers1 = 'From: '.$admin_mail.''. "\r\n";
			$headers1.= 'MIME-Version: 1.0' . "\r\n";
			$headers1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$coinera_board_mailer1.='
				<table width="85%" height="auto" style="border:1px solid #790000; background-color: rgba(255, 255, 213, 0.4); font-family:Arial, Helvetica, sans-serif; color:#3D1602; font-size:12px;">
					<tr>
						<th align="left" style="border-bottom:1px solid #790000;"><img src="'.$url.'images/coin_mail_logo.jpg" width="664"></th>
					 </tr>
					 <tr>
						<td align="left">
                        <table width="100%" >
								<tr>
									<td colspan="2" align="left">
										<strong><u>Seller Details</u></strong>
									</td>
								</tr>
								<tr>
									<td width="20%"><strong>Name</strong></td>
									<td width="2%">:</td>
									<td>'.$seller_name.'</td>
								</tr>
                                <tr>
									<td><strong>Email Id</strong></td>
									<td>:</td>
									<td>'.$seller_email.'</td>
								</tr>
								<tr>
									<td><strong>Contact No.</strong></td>
									<td>:</td>
									<td>'.$seller_phone.'</td>
								</tr>
								<tr>
									<td><strong>Street address</strong></td>
									<td>:</td>
									<td>'.$seller_adress.'</td>
								</tr>
								<tr>
									<td><strong>City</strong></td>
									<td>:</td>
									<td>'.$seller_city.'</td>
								</tr>
								<tr>
									<td><strong>State</strong></td>
									<td>:</td>
									<td>'.$seller_state.'</td>
								</tr>
								<tr>
									<td><strong>Country</strong></td>
									<td>:</td>
									<td>'.$seller_country.'</td>
								</tr>
							</table>
							
                            <hr style="border: 2px solid #790000; width: 655px;" />
							
							<table width="100%">
								<tr>
									<td colspan="2" align="left">
										<strong><u>Customers Details</u></strong>
									</td>
								</tr>
								<tr>
									<td width="20%"><strong>Name</strong></td>
									<td width="2%">:</td>
									<td>'.$u_name.'</td>
								</tr>
                                <tr>
									<td><strong>Email Id</strong></td>
									<td>:</td>
									<td>'.$u_mail.'</td>
								</tr>
								<tr>
									<td><strong>Contact No.</strong></td>
									<td>:</td>
									<td>'.$u_phone.'</td>
								</tr>
								<tr>
									<td><strong>Street address</strong></td>
									<td>:</td>
									<td>'.$u_street.'</td>
								</tr>
								<tr>
									<td><strong>City</strong></td>
									<td>:</td>
									<td>'.$u_city.'</td>
								</tr>
								<tr>
									<td><strong>State</strong></td>
									<td>:</td>
									<td>'.$u_state.'</td>
								</tr>
								<tr>
									<td><strong>Country</strong></td>
									<td>:</td>
									<td>'.$u_country.'</td>
								</tr>
							</table>
						</td>
					</tr>
					
                    <tr><td>&nbsp;</td></tr>
					
					<tr>
						<td align="left" >
							<table align="center" width="660" style="border:1px solid #790000; border-collapse:collapse; background-color:rgba(255, 255, 213, 0.4);">
								<tr>
									<td align="center" colspan="5" style="background-color:#800000; color:#FFFFFF; font-size:16px; font-family:Trebuchet MS; padding:5px 0;">Product Details</td>
								</tr>
								<tr style="border:1px solid #790000; border-style:dotted; background-color:#C79F6A; font-size: 14px;">
									<td align="center" width="25%" style="border:1px solid #790000; border-style:dotted;">Product Image</td>
                                    <td align="center" width="55%" style="border:1px solid #790000; border-style:dotted;">Product Name</td>
									<td align="center" width="20%" style="border:1px solid #790000; border-style:dotted;">Price Rs. </td>
								</tr>	
						'.$output.'
						'.$output1.'
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" style="color:#FFFFFF; background:#3D1602;">Copyright &copy; '.date('Y').' Coin Era</td>
					</tr>
				</table>';
				
			   $m_send1=@mail($emailto1, $subject1, $coinera_board_mailer1, $headers1);
			   
	 /***************************Mail Send To admin End*******************************/
		
		
		
			   
	 /*******************************Mail Send To Seller Start*************************************/
	   	
			$emailto2 = $seller_email;
			$subject2 = "Buyers Bidding Product Info:";
			$headers2 = 'From: '.$admin_mail.''. "\r\n";
			$headers2.= 'MIME-Version: 1.0' . "\r\n";
			$headers2.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$coinera_board_mailer2.='
				<table width="85%" height="auto" style="border:1px solid #790000; background-color: rgba(255, 255, 213, 0.4); font-family:Arial, Helvetica, sans-serif; color:#3D1602; font-size:12px;">
					<tr>
						<th align="left" style="border-bottom:1px solid #790000;"><img src="'.$url.'images/coin_mail_logo.jpg" width="664"></th>
					 </tr>
					 <tr>
						<td align="left">
							<table width="100%">
								<tr>
									<td colspan="2" align="left">
										<strong><u>Customers Details</u></strong>
									</td>
								</tr>
								<tr>
									<td width="20%"><strong>Name</strong></td>
									<td width="2%">:</td>
									<td>'.$u_name.'</td>
								</tr>
                                <tr>
									<td><strong>Email Id</strong></td>
									<td>:</td>
									<td>'.$u_mail.'</td>
								</tr>
								<tr>
									<td><strong>Contact No.</strong></td>
									<td>:</td>
									<td>'.$u_phone.'</td>
								</tr>
								<tr>
									<td><strong>Street address</strong></td>
									<td>:</td>
									<td>'.$u_street.'</td>
								</tr>
								<tr>
									<td><strong>City</strong></td>
									<td>:</td>
									<td>'.$u_city.'</td>
								</tr>
								<tr>
									<td><strong>State</strong></td>
									<td>:</td>
									<td>'.$u_state.'</td>
								</tr>
								<tr>
									<td><strong>Country</strong></td>
									<td>:</td>
									<td>'.$u_country.'</td>
								</tr>
							</table>
						</td>
					</tr>
					
                    <tr><td>&nbsp;</td></tr>
					
					<tr>
						<td align="left" >
							<table align="center" width="660" style="border:1px solid #790000; border-collapse:collapse; background-color:rgba(255, 255, 213, 0.4);">
								<tr>
									<td align="center" colspan="5" style="background-color:#800000; color:#FFFFFF; font-size:16px; font-family:Trebuchet MS; padding:5px 0;">Product Details</td>
								</tr>
								<tr style="border:1px solid #790000; border-style:dotted; background-color:#C79F6A; font-size: 14px;">
									<td align="center" width="25%" style="border:1px solid #790000; border-style:dotted;">Product Image</td>
                                    <td align="center" width="55%" style="border:1px solid #790000; border-style:dotted;">Product Name</td>
									<td align="center" width="20%" style="border:1px solid #790000; border-style:dotted;">Price Rs.</td>
								</tr>	
						'.$output.'
						'.$output1.'
							</table>
						</td>
					</tr>
					 <tr>
						<td><p>With regards ,</p><p style="font-weight:bold;">Coin Era Team</p></td>
					</tr>
					<tr>
						<td align="center" style="color:#FFFFFF; background:#3D1602;">Copyright &copy; '.date('Y').' Coin Era</td>
					</tr>
				</table>';
				
			   $m_send2=@mail($emailto2, $subject2, $coinera_board_mailer2, $headers2);
			   
	 /***************************Mail Send To Seller End*******************************/	   
			   
			   
			   
			   
			  
				if($m_send && $m_send1 && $m_send2){  ?>
                
					
                    
			<?php 
			
			$Date = date("Y-m-d");
			
			
				$query="UPDATE `product_status`
						SET 
						order_no 			='".$order_no."',
						purchase_date		= '".$Date."'
						WHERE product_id	=".$product_id;
				
				if(mysql_query($query)){ 
					$query_buyer="UPDATE `buyer_info`
							SET 
							expired		= 'N'
							WHERE user_id=".$_SESSION['user_id']." and 
							product_id	=".$product_id;
					mysql_query($query_buyer);		
				?>
                <center>
                        <div class="validation_message">Payment Successfully Done. Your Order No is <strong style="color:green;"><?=$order_no?></strong>. Thank You for Purchasing.</div>
                    </center>
					<?php
					unset($_SESSION['product_id']);
					}
				}else{ ?>
					<center>
                        <div class="validation_message">Mail Sendind Failed</div>
                    </center>
			<?php }//-------------------------------------Email code end here----------------------------------------------------//
			}else{
				header("Location:index.php");
				}
			   
		


?>


</div>

<?php
include "footer.php";
?>