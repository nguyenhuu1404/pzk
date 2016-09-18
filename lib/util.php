<?php
/**
 * pre variable with print_r
 * @param unknown $var variable for dumping
 */
function pre($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

/**
 * Ham hien thi memory tu byte sang dang MBs, KBs, Bytes
 *
 * @param int $mem Memory usage
 * @return string
 */
function display_mem($mem) {
	$rslt = array();
	$nots = array('Bytes', 'KBs', 'MBs');
	while($mem != 0) {
		$mod = $mem % 1024;
		$mem = ($mem - $mod) / 1024;
		$rslt[] = $mod;
	}
	$str = '';
	for($i = count($rslt) - 1; $i > -1; $i--) {
		$str .= $rslt[$i] . ' ' . $nots[$i] . ' ';
	}
	return $str;
}

/**
 * Benchmarking memory usage
 * @param string $return whether return string or echo string of memory usage
 * @return string
 */
function echo_memory_usage($return = false) {
	$mem_usage = memory_get_usage(true);

	if ($mem_usage < 1024)
		$var = $mem_usage." bytes";
	elseif ($mem_usage < 1048576)
	$var = round($mem_usage/1024,2)." kilobytes";
	else
		$var = round($mem_usage/1048576,2)." megabytes";

	if($return) {
		return $var;
	} else {
		echo $var;
		echo '<br/>';
	}

}
/**
 * Return % of cpu usage for running script
 * @return number
 */
function get_server_load() {
	if (stristr(PHP_OS, 'win')) {

		$wmi = new COM("Winmgmts://");
		$server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");

		$cpu_num = 0;
		$load_total = 0;

		foreach($server as $cpu){
			$cpu_num++;
			$load_total += $cpu->loadpercentage;
		}

		$load = round($load_total/$cpu_num);

	} else {

		$sys_load = sys_getloadavg();
		$load = $sys_load[0];

	}

	return (int) $load;

}

/**
 * Debug một mảng các bản ghi thành dạng bảng theo bootstrap
 * @param array $rows danh sách các bản ghi
 * @param string|array $fields các trường của các bản ghi
 */
function debug_table($rows, $fields = false) {
	if(is_string($fields)) {
		$fields = explodetrim(',', $fields);
	}
	if(!$fields) {
		$fields = @array_keys($rows[0]);
	}
	echo '<table class="table table-bordered">';
	echo '<tr>';
	foreach($fields as $field) {
		echo '<th>' . $field . '</th>';
	}
	echo '</tr>';
	foreach($rows as $row) {
		echo '<tr>';
		foreach($fields as $field) {
			echo '<td>';
			print_r(@$row[$field]);
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}

/**
 * Hàm debug dữ liệu giống hàm pre
 * @param mixed $data
 */
function debug($data = array()){
	if($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
}