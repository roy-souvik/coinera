$('.product_type').change(function(){

var product_type=$(this).val();

 
$('.outerdiv_frame').html('<center><img src="images/loader.gif" style="border-radius:18px;"></center>');
 
 
  if(product_type!=''){
	$.post('ajax_pages/get_products.php',{product_type:product_type},function(data){
	
		$('.outerdiv_frame').hide().fadeIn('normal').html(data);
	});
} else {
	$('.outerdiv_frame').html('<center><h1>Please Select A Product Type</h1></center>');
}  
 
 
});