<?php
$file = pzk_or(pzk_config('plugin_validate_src'), '/3rdparty/jquery/jquery.validate.min.js');
$additional = pzk_or(pzk_config('plugin_validate_additional_src'), '/3rdparty/jquery/additional-methods.min.js');
?>
<script src="{file}" type="text/javascript"></script>
<script src="{additional}" type="text/javascript"></script>
