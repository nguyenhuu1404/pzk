<?php
$timepickerJsFile = pzk_or(pzk_config('plugin_timepicker_js_src'), '/3rdparty/ui/jquery-ui-timepicker-addon.min.js');
$timepickerCssFile = pzk_or(pzk_config('plugin_timepicker_css_src'), '/3rdparty/ui/jquery-ui-timepicker-addon.min.css');
?>
<link rel="stylesheet" type="text/css" href="{timepickerCssFile}"/>
<script src="{timepickerJsFile}" type="text/javascript"></script>