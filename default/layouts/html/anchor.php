<?php
$button = '';
if($data->button) {
	$buttons = explode(' ', $data->button);
	foreach($buttons as &$btn) {
		$btn = 'btn-'. $btn;
	}
	$button = 'btn ' . implode(' ', $buttons);
}
?><a href="{prop src}" title="{prop title}" class="{prop class} {button}">{prop label}{children all}</a>