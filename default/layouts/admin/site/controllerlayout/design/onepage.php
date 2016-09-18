<?php
$item = $data->getItem();
$positions = $data->getPositions();
?>
<h1>Controller: {item[controller_name]}/{item[action_name]}</h1>
<div class="row">
<div class="col-xs-12">
<?php
foreach($positions as $pos) {
	$pos->display();
}
?>
</div>
</div>