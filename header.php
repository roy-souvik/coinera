<?php 
ob_start();
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
session_start();
include("includes/config.php");
include("includes/dbcon.php");

 if(!isset($_SESSION['msg'])){
	$_SESSION['msg']='';
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coin Era</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function() {	
	$("#navigation li").append("<span></span>");	
	//hover over
	$("#navigation li").hover(function() {	
		$(this).find("span").animate({
			height: "100%",width:"100%",left:"0px",top:"0px" 
		}, 250);
		
	} , function() { 							//callback function
		$(this).find("span").stop().animate({
			height: "0px",width:"0px",left:"50%",top:"40px"  
		}, 250);		
	});


/* ----------------------------------------------------------------------------------- */
/*var url = document.URL;
$('#navigation li a[href="'+url+'"]').addClass('active');*/ 	
var url=location.href.toLowerCase();

$('#navigation li a').each(function() {
if (url.indexOf(this.href.toLowerCase()) > -1) {
$(this).parent().addClass("active");
}
});
	
});


</script>

<div id="fb-root"></div>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</head>
<body>




<!---------------------------For Page Views code----------------------------------------->

<?php

$_SESSION['v']=0;
$sql=mysql_query("select * from views");
$count=mysql_num_rows($sql);

$dt=date("Y-m-d");

if($count>0){
	$sql_dt=mysql_query("select * from views where date='".$dt."'");
	$count_updt=mysql_num_rows($sql_dt);
	if($count_updt>0){
		$u_sql=mysql_fetch_array($sql_dt);
		$_SESSION['v']=$u_sql['view'];
		$t_view=$_SESSION['v']+1;
		$sql_update=mysql_query("update views set view=".$t_view." where date='".$dt."'");
	}
	else{
		$_SESSION['v']=1;
		$sql_up_insert=mysql_query("INSERT INTO views set view=".$_SESSION['v'].",date='".$dt."'");
		}
	
}else{
	$_SESSION['v']=1;
	$sql_insert=mysql_query("INSERT INTO views set view=".$_SESSION['v'].",date='".$dt."'");
}
?>

<!---------------------------End Page Views code----------------------------------------->



<div class="body_inner">
<?php
$page=$_SERVER["REQUEST_URI"];
$_SESSION['curr_page_name'] = $page;
?>
    <div class="header">
        <div class="header_left">
        <!-- ---------------------------------------------------------- --> 
        <div class="headre_fbk_frame">
         <div class="fb-like headre_fbk" data-href="http://arhamcreation.in/coinera/" data-send="false" data-layout="button_count" data-width="70" data-show-faces="true"></div>
        </div>
        <!-- ---------------------------------------------------------- -->
        <a href="#"><img src="images/fcebook.png" /></a>
        <a href="#"><img src="images/twitter.png" /></a>
        <a href="cart.php"><img src="images/view_cart.png" /></a>
        |
       <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { 
	   			if($_SESSION['sl_no']==1){
					$text='Item';
					} else{
						$text='Items';
						}
	   ?>
        <a href="cart.php">(<?=$_SESSION['sl_no']?>) <?=$text?></a>
        <?php } else{ ?>
		<a href="cart.php">View Cart</a>
		<?php }?>
        </div>
        <div class="coin_logo">
        <img usemap="#logo_map" width="283" height="198" src="images/coin_logo_blank.png" />
        <map name="logo_map">
          <area shape="poly" coords="106,142,29,146,31,192,270,190,258,148,178,130,196,91,191,63,174,41,147,31,126,34,110,44,99,58,93,71,95,95,112,120,107,143" href="index.php" />
        </map>
</div>
        <div class="header_register">
		 <table class="header_reg_table" border="0" cellspacing="0" cellpadding="0">	
    <?php
		if(!isset($_SESSION['user_name'])){
	?>
		<form id="login_form" name="login_form" method="post" action="check_login.php">

		<tr><td colspan="3"><span style="color:#DC0720;"><?php echo $_SESSION['msg']; ?></span></td></tr>			 
         	<tr>
                <td>Username</td><td>:</td>
                <td><input class="reg_t_inp" type="text" id="username" name="username" autocomplete="off"/></td>
            </tr>
            <tr>
                <td>Password</td><td>:</td>
                <td><input class="reg_t_inp" type="password" id="password" name="password" autocomplete="off"/></td>
            </tr>
			<tr><td colspan="3" class="btn_in_td"><input class="submit_btn" type="submit" id="submit" value="GO" name="submit"></td></tr>
	    <script>
			$('#submit').click(function() { 
				var user_name=$('#username').val();
				var pass=$('#password').val();
				if(user_name=='' || pass==''){
				
					alert('username or password cannot be left blank');
					return false;
				 }
				});
		</script>
		</form>	
            <tr>
                <td colspan="3" class="btn_in_td">
                <a style="margin-top:5px;" href="forgot_password.php">Forgot Password</a>
           		</td>
            </tr>
            <tr>
                <td colspan="3" class="btn_in_td">
                <a  href="register.php">Register</a>
                </td>
            </tr>
      </table>
			
	<?php } //end of if condition 
		
		else{
	?>
    <table class="header_reg_table header_logout" border="0" cellspacing="0" cellpadding="0">	
		<tr><td colspan="3" class="btn_in_td"><span style="font-size:18px;"><?php echo $_SESSION['msg']; ?></span></td></tr>		
		    <tr>
                <td colspan="3" class="btn_in_td">
					<a href="logout.php">Logout</a>
           		</td>
			</tr>
			<tr>
				<td colspan="3" class="btn_in_td">
					<a href="profile.php">My Account</a>
           		</td>
            </tr>
			<tr>
				<td colspan="3" class="btn_in_td">
					<a href="add_products.php">Add Products</a>
           		</td>
            </tr>
			<tr>
				<td colspan="3" class="btn_in_td">
					<a href="product_gallery.php">Place a bid</a>
				</td>
			</tr>
	<?php } ?>		
         </table>
        </div>
        <div id="menu-bar">
        <ul id="navigation">
			<li><a href="index.php">Home</a></li><li>|</li>
			<li><a href="about_us.php">About us</a></li><li>|</li>
			<li><a href="product_gallery.php">Products</a></li><li>|</li>
			<li><a href="contact_us.php">Contact us</a></li>
        </ul>
        </div>
    </div>
    
    <div id="container">