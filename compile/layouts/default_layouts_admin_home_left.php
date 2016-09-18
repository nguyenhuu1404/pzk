<div class="col-md-12">
	<?php $messages = pzk_notifier_messages(); ?>
	<?php foreach ( $messages as $item ) : ?>
		<h4 class="highlight label-<?php echo isset($item['type'])?$item['type']: '';?>"><?php echo isset($item['message'])?$item['message']: '';?></h4>
	<?php endforeach; ?>
	<?php $data->displayChildren('all');?>
</div>