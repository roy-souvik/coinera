<?

require('image_resize_func.php');


function upload_image($upload_image_dir,$upload_image_thumb_dir)
{
	$filename=$_FILES['image']['name'];
	$tmp_name=$_FILES['image']['tmp_name']; 
	$file_type=$_FILES['image']['type'];
	if(is_uploaded_file($tmp_name)) 
		if(strpos($file_type,"jpg")!=false || strpos($file_type,"jpeg")!=false || 
		   strpos($file_type,"png")!=false || strpos($file_type,"gif")!=false)
			if(move_uploaded_file($tmp_name,$upload_image_dir.'/'.$filename))
			{
				$image_resize = new SimpleImage();
				$image_resize->load($upload_image_dir.'/'.$filename);
				$image_resize->resizeToWidth(200);
				$image_resize->save($upload_image_thumb_dir.'/'.$filename);
				return $filename;
			}
	return false;
}



?>