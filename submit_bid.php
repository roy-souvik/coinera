<?php
session_start();
include("includes/config.php");
include("includes/dbcon.php");

if(isset($_REQUEST['edt']) && $_REQUEST['edt']!=''){
	if($_POST['bid_amount']>=$_POST['regular_price']){
		$edt_id=$_REQUEST['edt'];
		
		$b_user_id=$_SESSION['user_id'];
		$b_product_id=$_POST['product_id'];
		$b_price=$_POST['bid_amount'];
		$b_final=$b_price*2/100;
		$b_final_price=$b_final+$b_price;
		//$b_final_price=round($b_final_price, 2);
		$b_description=mysql_real_escape_string($_POST['description']);
		if($b_user_id!='' && $b_product_id!='' && $b_price!='' && $b_final_price!=''){
		$sql_insert="update bid_info
					set
					user_id         =".$b_user_id.",
					product_id      =".$b_product_id.",
					description     ='".$b_description."',
					bid_price       ='".$b_price."',
					final_bid_price ='".$b_final_price."'
					where id=".$edt_id; 
			mysql_query($sql_insert) or die("Error in Insert");
			/*echo '<script type="text/javascript">alert("Information Updated Successfully");</script>';
			echo "<script type='text/javascript'>window.location = 'product_details.php?product_id=".$b_product_id."&flag=1'</script>";*/
			echo "<script type='text/javascript'>window.location = 'edit_bid.php?id=".$edt_id."&edt_id=1'</script>";
			//header("location:product_details.php?product_id=".$b_product_id."&flag=1");
		}
	}else{
		echo "<script type='text/javascript'>window.location = 'edit_bid.php?id=".$edt_id."&edt_id=2'</script>";
	}
	
	
	
	
	
	 
	
}else{
	
	$b_user_id=$_SESSION['user_id'];
	$b_product_id=$_POST['product_id'];
	$b_price=$_POST['bid_amount'];
	$b_final=$b_price*2/100;
	$b_final_price=$b_final+$b_price;
	//$b_final_price=round($b_final_price, 2);
	$b_description=mysql_real_escape_string($_POST['description']);
	if($b_user_id!='' && $b_product_id!='' && $b_price!='' && $b_final_price!=''){
		if($_POST['bid_amount']>=$_POST['regular_price']){	
			$sql_insert="insert into bid_info
						set
						user_id         =".$b_user_id.",
						product_id      =".$b_product_id.",
						description     ='".$b_description."',
						bid_price       ='".$b_price."',
						final_bid_price ='".$b_final_price."',
						bid_date        =CURDATE()";
				mysql_query($sql_insert) or die("Error in Insert");
				$sql_buyer_info="INSERT INTO buyer_info
						  SET
						  user_id = ".$b_user_id.",
						  product_id = ".$b_product_id.",
						  status = 'Y'"; 
				mysql_query($sql_buyer_info);
				$_SESSION['check_price']='';
				echo '<script type="text/javascript">alert("Your Bid is placed");</script>';
				echo "<script type='text/javascript'>window.location = 'product_details.php?product_id=".$b_product_id."&flag=1'</script>";
		}else{
			$_SESSION['check_price']=2; 
			header("location:product_details.php?product_id=$b_product_id&flag=1");
		}
		
	}
	else{
		$_SESSION['check_price']=1; 
		header("location:product_details.php?product_id=$b_product_id&flag=1");
	}
	
	
}
	
	
	
	
	
	
	
?>