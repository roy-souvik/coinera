<?php include("header.php"); ?>
  <div class="outerdiv_frame">
<?php 
$http_url='http://'.$_SERVER["HTTP_HOST"].''.$_SESSION['login_page_url'];
	if(isset($_SESSION['login_page_url']) && ($http_url=$_SERVER['HTTP_REFERER'] )){
		$login_page_url=$_SESSION['login_page_url']; 
	}else {
		$login_page_url='profile.php'; 
		}
	
	//echo $_SERVER['HTTP_REFERER'];
 if(isset($_POST['submit'])){

	if(!empty($_POST['name']) && !empty($_POST['pass'])){
		
		 function input_sanitize($data){
			$data=strip_tags($data);
			$data=trim($data);
			$data=mysql_real_escape_string($data);
			return $data;
		} 
		
		$user_name=input_sanitize($_POST["name"]);
		$password=input_sanitize($_POST["pass"]);
		
		$query = "SELECT * FROM `user_info` where BINARY user_name='".$user_name."' AND password='".$password."'";
		$result = mysql_query($query);
		
		if(mysql_num_rows($result)== 1){
			$get_user_id=mysql_fetch_array($result);
			
			     $_SESSION['user_name'] = $get_user_id['user_name'];
				 $_SESSION['user_id'] = $get_user_id['id'];
				 $_SESSION['msg']='Welcome '.$user_name;
				
			header("Location:$login_page_url");
			}else{
				  echo '<div class="validation_message"><span style=\"color:red;\">Login Failed. Try again</span></div>';
				}
		}else{
		   echo '<div class="validation_message"><span style=\"color:red;\">Login Failed. Try again</span></div>';
		}
	}
?>



<?php if(!isset($_SESSION['user_name'])){ ?>
        
      <?php if($_SESSION['active_msg']!=''){ ?>
         <center id="active_msg">
            <div class="validation_message"><?=$_SESSION['active_msg']?></div>
         </center>
      <?php unset($_SESSION['active_msg']);}?>
    
    <div class="single_log">
    <form name="login_form" method="post">
    <table align="left" style="border-right:1px solid rgba(30, 30, 30, 0.3); padding-right:20px;">
           
                <tr><td style="font-size:18px; padding-bottom:20px;padding-top: 0;">Login</td></tr>
                <tr><td>Username</td></tr>
                
                <tr><td><input class="single_log_inp" type="text" id="username" name="name" autocomplete="off"/></td></tr>
                
                <tr><td>Password</td></tr>
                <tr><td><input class="single_log_inp" type="password" id="password" name="pass" autocomplete="off"/></td></tr>
                
                <tr>
                    <td align="left">
                    <a style="margin-left: 15px;line-height: 30px;" href="forgot_password.php">Forgot Password</a>
                    <input type="submit" value="SUBMIT" name="submit" class="cart_checkout_btn" style="float:left;"></td>
                </tr>
    </table>
    <table align="right" style="text-align:center; margin-top:50px;">
           
                <tr ><td  style="font-size:18px;">New to Coin Era ?</td></tr>
                <tr ><td>Get started now. It's fast and easy!</td></tr>
                <tr ><td>
                <a class="crt_a_link" href="register.php"> Register</a>
                </td></tr>
    </table>
    </form>	
    </div>

	<?php }else{
			header('location:'.$login_page_url);
		 }
	 ?>
     
  </div>
     
<?php include("footer.php"); ?>