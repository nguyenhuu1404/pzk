<?php
/*
$pattern = '/\[input([\d]+)\]/';
$replacement =	'<input class="input_dt" name="answers[12322_2][$1]" />';
$contentReplaced = preg_replace($pattern, $replacement, '[input1] <br /> [input2] <br /> [input21] <br /> [input22]');
echo $contentReplaced;
*/
/*
$bikers = null;
if(!file_exists('bikers.html')) {
	$bikers = file_get_contents('https://www.sunfrog.com/search/index.cfm?cId=52&search=motorcycle,%20biker&schTrmFilter=sales&navpill');
	file_put_contents('bikers.html', $bikers);
} else {
	$bikers = file_get_contents('bikers.html');
}
*/
/*
echo ($start = microtime()). '<br />';
for($i = 0; $i < 1000000; $i++) {
	$kq = md5('Càng ngày càng dài, càng ngày càng rộng ' . $i);
}
echo ($end = microtime()). '<br />'; 
*/
/*
echo time();
*/
const MY_CONST = true;
const BR = '<br />';
if(MY_CONST) {
	echo 'true';echo BR;
} else {
	echo 'false';echo BR;
}
if(MY_CONST) {
	const MY_CONST_2 = 'Hello';
} else {
	const MY_CONST_2 = 'World';
}

var_export(MY_CONST_2); echo BR;