$(document).ready(function()
{

$(".product_type").change(function(){
var dataString = 'id='+ $(this).val();
if($(this).val()){
$.ajax({type: "POST",url: "ajax_pages/get_cat.php",data: dataString,cache: false,success: function(html){
$(".txtHint").html(html);
$(".outerdiv_frame").hide();
$(".txtHint1_a").hide();
		} 
	});
	
 }else{ $(".txtHint_a").hide(); $(".txtHint1_a").hide(); $(".outerdiv_frame").show();}
});




$('.txtHint').live("change",function(){	
if($(this).val()>0){							   
$.ajax({type: "POST",url: "ajax_pages/get_prdt.php",data: { id: $(this).val() },cache: false,success: function(html){
$(".txtHint_b").hide();
$(".txtHint1").html(html);
} 
});
}else{
$(".txtHint_b").show();
$(".txtHint1_a").hide();
	}
});


});