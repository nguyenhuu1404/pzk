<?php
/**
 * Replace nhiều chuỗi con
 * @param Array $replacements Các chuỗi con cần thay thế dạng : search => replace
 * @param String $str Chuỗi lớn
 * @return String Chuỗi sau khi được thay thế
 */
function pzk_replace($replacements, $str) {
	foreach($replacements as $search => $replace) {
		$str = str_replace($search, $replace, $str);
	}
	return $str;
}

/**
 * Upper case first letter of a string
 *
 * @param String 	$str input string
 * @return 	String 	uppercased first letter
 */
function str_ucfirst($str) {
	return strtoupper($str[0]) . substr($str, 1);
}

/**
 * Chuyển tiếng việt có dấu thành tiếng việt không dấu
 * @param string 	$str chuỗi tiếng việt có dấu
 * @return string 	chuỗi tiếng việt không dấu
 */
function khongdau($str) {
    return bodau($str);
}

/**
 * Chuyển một chuỗi thành dạng alias
 * @param string $str chuỗi tiếng việt có dấu
 * @return string chuỗi dạng alias
 */
function khongdauAlias($str) {
	$alias = khongdau($str);
	$aliasTemp = '';
	for($i = 0; $i < strlen($alias); $i++) {
		$chrInt = ord(strtolower($alias[$i]));
		if (($chrInt >= ord('a') && $chrInt <= ord('z')) || ($chrInt >= ord('0') && $chrInt <= ord('9')) || $chrInt == ord('-') || $chrInt == ord('/')) {
			$aliasTemp .= $alias[$i];
		}
	}
	return $aliasTemp;
}
 
/**
 * Decode một chuỗi theo định dạng url
 * @param string $raw_url_encoded chuỗi định dạng ban đầu
 * @return string chuỗi kết quả
 */
function utf8_rawurldecode($raw_url_encoded){ 
    $enc = rawurldecode($raw_url_encoded); 
    if(utf8_encode(utf8_decode($enc))==$enc){; 
        return rawurldecode($raw_url_encoded); 
    }else{ 
        return utf8_encode(rawurldecode($raw_url_encoded)); 
    } 
} 

/**
 * Thay thế dấu ngăn cách đường dẫn thành dấu ngăn cách của hệ thống
 * @param string $path đường dẫn
 * @return string đường dẫn đã được thay thế
 */
function replace_path($path) {
	$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
	return $path;
}

/**
 * Thoát các ký tự html
 * @param string $str Chuỗi html
 * @return string Chuỗi được xử lý thoát html
 */
function html_escape($str) {
	return htmlspecialchars($str, ENT_COMPAT, 'utf-8');
}

/**
 * Chuyển tiếng việt có dấu thành tiếng việt không dấu
 * @param string 	$str chuỗi tiếng việt có dấu
 * @return string 	chuỗi tiếng việt không dấu
 */
function bodau ($str){ 
	 $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ", 
	"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ", 
	"ì","í","ị","ỉ","ĩ", 
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ", 
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ", 
	"ỳ","ý","ỵ","ỷ","ỹ", 
	"đ", 
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă" 
	,"Ằ","Ắ","Ặ","Ẳ","Ẵ", 
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ", 
	"Ì","Í","Ị","Ỉ","Ĩ", 
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ" 
	,"Ờ","Ớ","Ợ","Ở","Ỡ", 
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ", 
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ", 
	"Đ"," ");  
	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a", 
	"e","e","e","e","e","e","e","e","e","e","e", 
	"i","i","i","i","i", 
	"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o", 
	"u","u","u","u","u","u","u","u","u","u","u", 
	"y","y","y","y","y", 
	"d", 
	"A","A","A","A","A","A","A","A","A","A","A","A" 
	,"A","A","A","A","A", 
	"E","E","E","E","E","E","E","E","E","E","E", 
	"I","I","I","I","I", 
	"O","O","O","O","O","O","O","O","O","O","O","O" 
	,"O","O","O","O","O", 
	"U","U","U","U","U","U","U","U","U","U","U", 
	"Y","Y","Y","Y","Y", 
	"D","-"); 
	$str=str_replace($marTViet,$marKoDau,$str); 
	return $str; 
}

/**
 * Cắt chuỗi theo số từ xác định
 * @param string $str chuỗi cần cắt
 * @param number $count số từ cần cắt
 * @return string chuỗi đã được cắt
 */
function cut_words($str, $count = 150) {
	$words = explode(' ', $str);
	if($count < count($words)) {
		$result = '';
		for($i = 0; $i < $count; $i++) {
			$result .= $words[$i] . ' ';
		}
		$result.= '...';
		return $result;
	} else {
		return $str;
	}
}

/**
 * Cắt chuỗi theo số ký tự xác định
 * @param string $str chuỗi cần cắt
 * @param number $count số ký tự cần cắt
 * @return string chuỗi đã được cắt
 */
function cut_chars($str, $count = 400) {
	if(strlen($str) <= $count) {
		return $str;
	} else {
		return substr($str, 0, $count) . ' ...';
	}
}

/**
 * Chuyển các biểu thức latex trong văn bản thành dạng ảnh
 * @param string $content văn bản có chứa biểu thức latex
 * @return string
 */
function getLatex($content) {
	$content = str_replace("[/", "<img src='http://latex.codecogs.com/gif.latex?", $content);
	$content = str_replace("/]", "'  />", $content);

	return $content;
}

//ma hoa chuoi
function encrypt($pure_string, $encryption_key) {
	$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
	$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
	return $decrypted_string;
}