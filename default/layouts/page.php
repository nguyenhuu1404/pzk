<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns# 
				  fb: http://ogp.me/ns/fb# 
				  article: http://ogp.me/ns/article#">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{prop title}</title>
		<meta property="og:type"  content="og:article" />
		<meta property="og:image" content="<?=BASE_URL?>{prop img}"/> 
		<meta property="og:title" content="{prop title}"/> 
		<meta property="og:site_name" content="nextnobels.com"/> 
		<meta property="og:url" content="<?=BASE_URL?><?php echo $_SERVER['REQUEST_URI']?>"/> 
		<meta property="og:description" content="{prop brief}" />
		<meta name="keywords" content="{prop keywords}" />
		<meta name="description" content="{prop description}" />
		<script type="text/javascript">
		BASE_URL = '<?php echo BASE_URL ?>';
		BASE_REQUEST = '<?php echo BASE_REQUEST ?>';
		serverTime = <?php echo $_SERVER['REQUEST_TIME']?>;
		serverMicroTime = <?php echo microtime(true) * 1000?>;
		setInterval(function() {
			serverTime++;
		}, 1000);
		setInterval(function() {
			serverMicroTime++;
		}, 1);
		function getServerTime() {
			return serverTime;
		}
		</script>
		<?php if(COMPILE_MODE && COMPILE_JS_MODE) : ?>
		<script type="text/javascript" src="/default/skin/<?php echo pzk_app()->getPathByName()?>.js?v=<?php echo filemtime(BASE_DIR . '/default/skin/' . pzk_app()->getPathByName() . '.js'); ?>"></script>
		<?php endif;?>
		{children [id=head]}
		<?php
		if(!DEBUG_MODE && strpos(pzk_request()->getController(), 'admin_') === false):
		?>
		<?php if(1):?>
		<script language="JavaScript">
		<!--
		var dictionaries = "ev_ve";
		// -->
		</script>
		<script language="JavaScript1.2" src="http://vndic.net/js/vndic.js" type='text/javascript'></script>
		<?php endif;?>
		<?php if(0): ?>
		<script language="JavaScript" type="text/javascript">
		<!--
		var dictionaries = "eng2vie_vie2eng_foldoc";
		// -->
		</script>
		<script language="JavaScript1.2" src="http://static.vdict.com/js/vdict.js" type='text/javascript'></script>
		<?php endif; ?>
			

		<?php endif; ?>
	</head>
	<body>
	<div id="fb-root"></div>
	{children [id=body]}
	
<?php if (count($data->jsInstances)) :?>
	<script type="text/javascript">
	pzk_request = <?php echo json_encode(pzk_request()->getFilterData()); ?>;
	pzk_init(<?php echo json_encode($data->jsInstances) ?>);
	pzk.runOnload();
	</script>
<?php endif; ?>

<?php if(defined('DEBUG_MODE') && DEBUG_MODE):?>
	<div class="clear">
	<?php 
		$debugs = _db()->getDebugs();
		foreach($debugs as $index => $debug) {
			echo ($index+1) .'. ' . $debug['query']. '<br />';
			if(DEBUG_LEVEL > 1) {
				echo '<pre>';
				echo nl2br($debug['backtrace']);
				echo '</pre>';	
			}
			
		}
	?>
	</div>
<?php endif;?>
	</body>
</html>