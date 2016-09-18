<?php 
$items = $data->getItems(); ?>
{each $items as $item}
{item[name]}<br />
{/each}