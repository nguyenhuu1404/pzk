<?php
$select2JsFile = pzk_or(pzk_config('plugin_bootstrap_select2_js_src'), '/3rdparty/bootstrap3/select2.js');
$select2CssFile = pzk_or(pzk_config('plugin_bootstrap_select2_css_src'), '/3rdparty/bootstrap3/select2.css');
$select2bootstrapCssFile = pzk_or(pzk_config('plugin_bootstrap_select2_bootstrap_css_src'), '/3rdparty/bootstrap3/select2-bootstrap.css');
?>
<link rel="stylesheet" type="text/css" href="<?php echo isset($select2CssFile)?$select2CssFile: '';?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo isset($select2bootstrapCssFile)?$select2bootstrapCssFile: '';?>"/>
<script src="<?php echo isset($select2JsFile)?$select2JsFile: '';?>" type="text/javascript"></script>