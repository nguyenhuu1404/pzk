<?php
$tab = '|&nbsp;&nbsp;&nbsp;&nbsp;';

$content = rtrim(str_repeat($tab, $data->getLevel()), '&nbsp;').'__';
?>
{content}
<input id="{data.getIndex()}_{data.getItemId()}" type="text" name="{data.getIndex()}[{data.getItemId()}]" value="{data.getValue()}" rel="{data.getItemId()}" style="width: 20px;" />