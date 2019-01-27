$('#user_name').keyup(function(){

var username=$(this).val();

$('#username_status').html('<img src="images/loader.gif" style="border-radius:18px;width:24px;hetght:24px;">');
 
 if(username!=''){
	$.post('ajax_pages/check_username.php',{username:username},function(data){
	
		$('#username_status').html(data);
	});
} else {
	$('#username_status').html('');
}  

});