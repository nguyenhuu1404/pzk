<?php
$file = pzk_or(pzk_config('plugin_jquery_src'), '/3rdparty/jquery/jquery-2.1.4.min.js');
?>
<script src="<?php echo isset($file)?$file: '';?>" type="text/javascript"></script>
