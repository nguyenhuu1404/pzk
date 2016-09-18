<?php
$columns = $data->getColumns();
//debug($columns);die();
?>

<div class="row">
{each $columns as $column}
<div class="col-xs-{column[col]}">
    <?php $data->displayChildren('[column='.$column['index'].']');?>
</div>
{/each}
</div>