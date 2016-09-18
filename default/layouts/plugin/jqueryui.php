<?php
$jqueryuiJsFile = pzk_or(pzk_config('plugin_jqueryui_js_src'), '/3rdparty/ui/jquery-ui.min.js');
$jqueryuiCssFile = pzk_or(pzk_config('plugin_jqueryui_css_src'), '/3rdparty/ui/jquery-ui.min.css');
?>
<link rel="stylesheet" type="text/css" href="{jqueryuiCssFile}" />
<script src="{jqueryuiJsFile}" type="text/javascript"></script>