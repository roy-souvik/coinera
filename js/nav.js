$(document).ready(function() {

$('.page').click(function() {

	$('.outerdiv_frame').html('<center style="margin-top:100px;"><img src="images/loader.gif"></center>');

	var flag=$(this).attr('name');
	var flags=$(this).attr('value');

	$.post('product_gallery_next.php',{ name:flag,names:flags },function(data) {

	$('.outerdiv_frame').html(data);
	});
});





});