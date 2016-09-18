<?php
$item = $data->getItem();
$positions = $data->getPositions();
?>
<h1>Controller: {item[controller_name]}/{item[action_name]}</h1>
<?php
foreach($positions as $pos) {
	$pos->display();
}
?>