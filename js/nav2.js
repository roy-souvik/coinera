$(document).ready(function() {

$('.page').click(function() {

	$('.outerdiv_frame').html('<center style="margin-top:100px;"><img src="images/loader.gif"></center>');

	var flag=$(this).attr('name');
	var flags=$(this).attr('value');

	$.post('ajax_pages/get_products_next.php',{ product_type:flag,names:flags },function(data) {

	$('.outerdiv_frame').html(data);
	});
});





});