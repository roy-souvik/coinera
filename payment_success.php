<?php
include("header.php");

if(empty($_SESSION['user_name']) && !isset($_SESSION['cart'])){
	header('location:index.php');
} elseif(isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_SESSION['user_name'])){
	
?>

  <div class="outerdiv_frame"> 
	

   
    <?php
	
	
		$sql=mysql_fetch_array(mysql_query("select * from user_info where id=".$_SESSION['user_id']));
		$sql1=mysql_fetch_array(mysql_query("select * from admin_master where admin_id=1"));
		$u_name=$sql['first_name'].' '.$sql['last_name'];
		$u_mail=$sql['email_id'];
		$u_phone=$sql['phone'];
		$u_street=$sql['address'];
		$u_city=$sql['city'].' - '.$sql['zip_code'];
		$u_state=$sql['state'];
		$u_country=$sql['country'];
		$admin_mail=$sql1['admin_mail'];
		
	
		
		foreach($_SESSION['cart'] as $product_id => $quantity) {	
		
			$sql = "SELECT title, images, direct_price, description FROM product_info WHERE id =".$product_id;
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0) {
					list($title, $images, $direct_price, $description) = mysql_fetch_array($result);
			
			$line_cost = $direct_price * $quantity;		//work out the line cost
			$line_cost = round($line_cost, 2);
			$total = $total + $line_cost;			//add to the total cost
			$total = $total+($total/50);
			$total = round($total, 2);

			$output.='<tr height="80">';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;"><img src="http://localhost/coinera/ProductImage/thumbs/'.$images.'" width="70" height="70"></td>';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;">'.$title.'</td>';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;">'.$quantity.'</td>';
			$output.= '<td align="center" style="border:1px solid #790000; border-style:dotted;">Rs. '.$line_cost.'</td>';
			$output.='</tr>';
			}
		}
		
		$output1.='<tr style="background-color:#C79F6A;">';
		$output1.= '<td align="right" colspan="4" >Grand Total : <strong>Rs. '.$total.'</td>';
		$output1.='</tr>';
		
   
	
//------------------------------------Email code start here------------------------------------------------------


	$emailto = $u_mail;
	$subject = "Buyers Product Info:";
	$headers = 'From: '.$admin_mail.''. "\r\n";
	$headers.= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$coinera_board_mailer.='
		<table width="85%" height="auto" style="border:1px solid #790000; background-color: rgba(255, 255, 213, 0.4); font-family:Arial, Helvetica, sans-serif; color:#3D1602; font-size:12px;">
			<tr>
				<th align="left" style="border-bottom:1px solid #790000;"><img src="http://arhamcreation.in/coinera/images/coin_mail_logo.jpg" width="664"></th>
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
							<td align="center" width="47%" style="border:1px solid #790000; border-style:dotted;">Product Name</td>
							<td align="center" width="10%" style="border:1px solid #790000; border-style:dotted;">Qty.</td>
							<td align="center" width="18%" style="border:1px solid #790000; border-style:dotted;">Price $</td>
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

		
			$emailto1 = $admin_mail;
			$subject1 = "Selling Product Info:";
			$headers1 = 'From: '.$admin_mail.''. "\r\n";
			$headers1.= 'MIME-Version: 1.0' . "\r\n";
			$headers1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$coinera_board_mailer1.='
				<table width="85%" height="auto" style="border:1px solid #790000; background-color: rgba(255, 255, 213, 0.4); font-family:Arial, Helvetica, sans-serif; color:#3D1602; font-size:12px;">
					<tr>
						<th align="left" style="border-bottom:1px solid #790000;"><img src="http://arhamcreation.in/coinera/images/coin_mail_logo.jpg" width="664"></th>
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
                                    <td align="center" width="47%" style="border:1px solid #790000; border-style:dotted;">Product Name</td>
									<td align="center" width="10%" style="border:1px solid #790000; border-style:dotted;">Qty.</td>
									<td align="center" width="18%" style="border:1px solid #790000; border-style:dotted;">Price $</td>
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
		
		
			   $m_send1=@mail($emailto1, $subject1, $coinera_board_mailer1, $headers1);
			   
				if($m_send && $m_send1){ unset($_SESSION['cart']); ?>
                    <center>
                        <div class="validation_message">Payment Successfully Done. Thank You for Purchasing.</div>
                    </center>
			<?php }else{ ?>
            		<center>
                        <div class="validation_message">Mail Sendind Failed.</div>
                    </center>
			<?php } //-------------------------------------Email code end here----------------------------------------------------//
			

	 }else{
		header("Location:index.php");
		}

?>

</div>

<?php
include "footer.php";
?>