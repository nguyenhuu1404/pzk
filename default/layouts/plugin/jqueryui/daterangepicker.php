<?php
$daterangepickermomentJsFile = pzk_or(pzk_config('plugin_daterangepicker_moment_js_src'), '/3rdparty/daterangepicker/moment.min.js');
$daterangepickerJsFile = pzk_or(pzk_config('plugin_daterangepicker_js_src'), '/3rdparty/daterangepicker/jquery.daterangepicker.js');
$daterangepickerCssFile = pzk_or(pzk_config('plugin_daterangepicker_css_src'), '/3rdparty/daterangepicker/daterangepicker.css');
?>
<link rel="stylesheet" type="text/css" href="{daterangepickerCssFile}"/>
<script src="{daterangepickermomentJsFile}" type="text/javascript"></script>
<script src="{daterangepickerJsFile}" type="text/javascript"></script>