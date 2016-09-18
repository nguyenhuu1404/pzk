<?php
$file = pzk_or(pzk_config('plugin_tinymce_src'), '/3rdparty/tinymce/tinymce.min.js');
?>
<script src="<?php echo isset($file)?$file: '';?>" type="text/javascript"></script>
