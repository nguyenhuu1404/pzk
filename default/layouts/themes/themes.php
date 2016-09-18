<?php $themes = $data -> getThemes(); 
?>

{each $themes as $theme}
	<?php if(file_exists(BASE_DIR . '/themes/'.$theme['name'] . '/skin/css/style.css')): ?>
		<link rel="stylesheet" type="text/css" property="stylesheet" href="/themes/{theme[name]}/skin/css/style.css" />
	<?php elseif(file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getAppPath() . '/themes/'.$theme['name'] . '/css/style.css')) : ?>
		<link rel="stylesheet" type="text/css" property="stylesheet" href="/default/skin/<?php echo pzk_request()->getAppPath(); ?>/themes/{theme[name]}/css/style.css" />
	<?php endif; ?>
	<?php if(file_exists(BASE_DIR . '/themes/'.$theme['name'] . '/skin/js/main.js')): ?>
		<script type="text/javascript" src="/themes/{theme[name]}/skin/js/main.js"></script>
	<?php elseif(file_exists(BASE_DIR . '/default/skin/' . pzk_request()->getAppPath() . '/themes/'.$theme['name'] . '/js/main.js')) : ?>
		<script type="text/javascript" src="/default/skin/<?php echo pzk_request()->getAppPath(); ?>/themes/{theme[name]}/js/main.js"></script>
	<?php endif; ?>
{/each}