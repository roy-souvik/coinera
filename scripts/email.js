$('#email_id').blur(function(){

var email_id=$(this).val();

$('#email_id_status').html('<img src="images/loader.gif" style="border-radius:18px;width:24px;hetght:24px;">');

if(email_id!=''){
	$.post('ajax_pages/check_email.php',{email_id:email_id},function(data){
	
		$('#email_id_status').text(data);
	});
} else {
	$('#email_id_status').text('');
}

});