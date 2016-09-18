<?php
$files = $data->getFiles();
$module = $data->getModule();
$itemId = $data->getItemId();
$curentUrl = pzk_request('file');
?>
<h4>File plugin</h4>
<ul class="nav nav-pills">
{each $files as $file}
    <?php if(is_file($file)) { $url = urlencode($file); if($curentUrl == $file){ $active ="class='active'";} else {$active='';} ?>
        <li role="presentation" {active}><a href="/admin_{module}/edit/{itemId}?file={url}">{file}</a></li>
    <?php }?>
{/each}
</ul>
