<?php
function createThumb($fromFile, $width, $height) {

	if (!file_exists(BASE_DIR . $fromFile)) return '';
	
	$fileName = basename($fromFile);
	
	$toFile = '/uploads/thumbs/' . $width . 'x' . $height . '_' . $fileName;
	
	if (file_exists(BASE_DIR . $toFile)) return $toFile;
	
	// include image processing code
	require_once(BASE_DIR . '/libraries/thumb/image.class.php');
	
	$ext = array_pop(explode('.', $fileName));
	
	switch(strtolower($ext)) {
		case 'jpg': case 'jpeg':
			$image_type = 2; break;
		case 'gif':
			$image_type = 1; break;
		case 'png': 
			$image_type = 3; break;
		default: 
			$image_type = 1; break;
	}
	
	$img = new Zubrag_image();
	// initialize
	$img->max_x        = $width;
	$img->max_y        = $height;
	$img->cut_x        = 0;
	$img->cut_y        = 0;
	$img->quality      = 75;
	$img->save_to_file = 1;
	$img->image_type   = $image_type;
	$img->GenerateThumbFile(BASE_DIR . $fromFile,BASE_DIR . $toFile);
	return $toFile;
}
?>