<?php
$items = $data->getItems();
?>
<div class="row">
{each $items as $item}
  <div class="col-sm-3 col-md-3">
    <div class="thumbnail">
	  <a href="/{item[admin_controller]}">
      <img src="{item[thumbnail]}" alt="{item[name]}">
	  </a>
      <div class="caption">
        <h3 class="text-center"><a href="/{item[admin_controller]}">{item[name]}</a></h3>
	  </div>
    </div>
  </div>
{/each}
</div>