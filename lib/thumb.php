<?php
/**
 * Tạo file ảnh thumb từ file ảnh gốc theo kích cỡ
 * @param string $fromFile tên file ảnh
 * @param int $width kích cỡ chiều rộng
 * @param int $height kích cỡ chiều cao
 * @return string tên file thumbnail
 */
function createThumb($fromFile, $width, $height) {
	if (strpos($fromFile, '/') !== 0) $fromFile = '/' . $fromFile; 
	if (!$fromFile) return '';
	if (!file_exists(BASE_DIR . $fromFile)) return '';
	
	$fileName = basename($fromFile);
	$tmp = explode('.', $fileName);
	$ext = array_pop($tmp);
	
	$toFile = '/uploads/thumbs/' . $width . 'x' . $height . '_' . md5($fileName) . '.' . $ext;
	
	if (file_exists(BASE_DIR . $toFile)) return $toFile;
	
	// include image processing code
	require_once(BASE_DIR . '/lib/thumb/image.class.php');
	
	
	switch(strtolower($ext)) {
		case 'gif':
			$image_type = 1; break;
		case 'jpg': case 'jpeg':
			$image_type = 2; break;
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