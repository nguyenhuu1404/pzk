<?php $fields = $data->getFields();
$item = $data->getRow();
?>
<?php foreach ( $fields as $field ) : ?>
<?php 
	$fieldObj = pzk_obj('core.db.grid.field.' . $field['type']); 
	foreach($field as $key => $val) {
		$fieldObj->set($key, $val);
	}
	$fieldObj->setItemId($item['id']);
	if($fieldObj->getType() == 'parent') {
		$fieldObj->setLevel($item['level']);
	}
	if($fieldObj->getType() == 'ordering') {
		$isOrderingField = true;
		$fieldObj->setLevel(@$item['level']);
	}
	$fieldObj->setRow($item);
	$fieldObj->setValue(@$item[$field['index']]);
?>
	<strong><?php echo isset($fieldObj)?$fieldObj->getLabel(): '';?></strong><br />
	<?php $fieldObj->display(); ?><?php echo isset($data)?$data->getDelimiter(): '';?>
<?php endforeach; ?>