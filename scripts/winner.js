$(document).ready(function() {

$('.winner').dblclick(function() {
	
	var id=$(this).attr('id');  // id of the bidder for making the winner
	var product_id=$('.product_id').val();// id of the product for setting the status to 'N'
	

/* ------------------------------------------------------------------------------------------------ */	
$('#dialog').attr('title','Make Winner').html('<table><tr><td>Remarks</td><td>:</td><td><textarea class="remarks" name="remarks" id="remarks" style="height: 70px;"></textarea></td></tr>'+																			
												'</table><div id="contact_form">').dialog({buttons:{'SUBMIT':function() {
	 
	// $(this).dialog('close'); // execute the code after clicking the button

	var remarks = $("#remarks").val();
		if (remarks == "") {
      alert('Please enter a remark');
      $("#remarks").focus();
      return false;
    }
	
	
	
/* --------- Ajax Request ------------------------------ */	
		
  if(remarks!=''){
  $('.validation_message').fadeIn('normal').html('<center><img src="images/loader.gif" style="width:56px;border-radius:18px;"></center>');
  
	$.post('ajax_pages/winner.php',{user_id:id,remarks:remarks,product_id:product_id},function(data){
	
		$('.validation_message').hide().fadeIn('normal').html(data);
	});
}
/* ----------------------------------------------- */
	$(this).dialog('close'); // execute the code after clicking the button
	
}},closeOnEscape:true,draggable:false,resizable:false,modal:true});	
	
/* ------------------------------------------------------------------------------------------------- */
  }); // Double click function [END]

}); //document.ready [END]