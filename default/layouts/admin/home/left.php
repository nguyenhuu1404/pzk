<div class="col-md-12">
	<?php $messages = pzk_notifier_messages(); ?>
	{each $messages as $item}
		<h4 class="highlight label-{item[type]}">{item[message]}</h4>
	{/each}
	{children all}
</div>