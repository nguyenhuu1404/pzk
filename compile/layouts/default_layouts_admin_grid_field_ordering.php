<?php
$tab = '|&nbsp;&nbsp;&nbsp;&nbsp;';

$content = rtrim(str_repeat($tab, $data->getLevel()), '&nbsp;').'__';
?>
<?php echo isset($content)?$content: '';?>
<input id="<?php echo isset($data)?$data->getIndex(): '';?>_<?php echo isset($data)?$data->getItemId(): '';?>" type="text" name="<?php echo isset($data)?$data->getIndex(): '';?>[<?php echo isset($data)?$data->getItemId(): '';?>]" value="<?php echo isset($data)?$data->getValue(): '';?>" rel="<?php echo isset($data)?$data->getItemId(): '';?>" style="width: 20px;" />