<?php
/**
 * Hiển thị giá tiền 200000 thành 200.000đ
 * @param float $priceFloat số tiền
 * @return string giá tiền
 */
function product_price($priceFloat) {
	$symbol = 'đ';
	$symbol_thousand = '.';
	$decimal_place = 0;
	$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
	return $price.$symbol;
}

/**
 * Hiển thị ngày giờ từ dạng mysql datetime hoặc dạng số nguyên
 * @param mixed $date ngày giờ dạng mysql hoặc dạng số nguyên
 * @return string Chuỗi hiển thị ngày giờ
 */
function format_date($date) {
	if(!is_numeric($date)) {
		$date = strtotime($date);
	}
	return date('d/m/y H:i', $date);
}

/**
 * Hiển thị dung lượng file dễ nhìn
 * @param int $size dung lượng dạng số nguyên
 * @param string $unit Đơn vị cần chuyển
 * @return string Kết quả dạng KBs, GBs, MBs
 */
function humanFileSize($size,$unit="") {
  if( (!$unit && $size >= 1<<30) || $unit == "GB")
    return number_format($size/(1<<30),2)."GB";
  if( (!$unit && $size >= 1<<20) || $unit == "MB")
    return number_format($size/(1<<20),2)."MB";
  if( (!$unit && $size >= 1<<10) || $unit == "KB")
    return number_format($size/(1<<10),2)."KB";
  return number_format($size)." bytes";
}

// seconds time to hours minutes seconds
/**
 * Chuyển đổi thời gian dạng giây thành cấu trúc giờ phút giây
 * @param int $seconds số giây
 * @return multitype:number
 */
function secondsToTime($seconds)
{
	// extract hours
	$hours = floor($seconds / (60 * 60));

	// extract minutes
	$divisor_for_minutes = $seconds % (60 * 60);
	$minutes = floor($divisor_for_minutes / 60);

	// extract the remaining seconds
	$divisor_for_seconds = $divisor_for_minutes % 60;
	$seconds = ceil($divisor_for_seconds);

	// return the final array
	$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
	);
	return $obj;
}

function time_duration($seconds) {
	$time = secondsToTime($seconds);
	$hour = $time['h'];
	$min = $time['m'];
	$sec = $time['s'];

	$resultStrTime = '';

	if($hour) {
		$resultStrTime .= $hour.' giờ ';
	}

	if($min) {
		$resultStrTime .= $min.' phút ';
	}

	if($sec) {
		$resultStrTime .= $sec.' giây ';
	}
	return $resultStrTime;
}


function startEndDateOfWeek($week, $year, $frontend=false)  
{  
	if($frontend){
		$format = 'd-m-Y';
	}else{
		$format = 'Y-m-d';
	}
	$time = strtotime("1 January $year", time());  
    $day = date('w', $time);  
    $time += ((7*$week)+1-$day)*24*3600;  
    $dates['startdate'] = date($format, $time);  
    $time += 6*24*3600;  
    $dates['enddate'] = date($format, $time);  
    return $dates;  
} 

