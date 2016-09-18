<?php
$plugins = $data->getPlugins();
foreach($plugins as $plugin) {
    $pluginObj = pzk_obj('plugin.' . $plugin['name']);
    $pluginObj->display();
}