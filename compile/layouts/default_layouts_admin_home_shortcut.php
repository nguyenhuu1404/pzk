<?php
$items = $data->getItems();
?>
<div class="row">
<?php foreach ( $items as $item ) : ?>
  <div class="col-sm-3 col-md-3">
    <div class="thumbnail">
	  <a href="/<?php echo isset($item['admin_controller'])?$item['admin_controller']: '';?>">
      <img src="<?php echo isset($item['thumbnail'])?$item['thumbnail']: '';?>" alt="<?php echo isset($item['name'])?$item['name']: '';?>">
	  </a>
      <div class="caption">
        <h3 class="text-center"><a href="/<?php echo isset($item['admin_controller'])?$item['admin_controller']: '';?>"><?php echo isset($item['name'])?$item['name']: '';?></a></h3>
	  </div>
    </div>
  </div>
<?php endforeach; ?>
</div>