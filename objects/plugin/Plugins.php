<?php
class PzkPluginPlugins extends PzkObject {
    public $layout = 'plugin/plugins';
    public function getPlugins() {
        $data = _db()->select('*')->fromPackages()->whereStatus('1')->whereType('plugin')->result();
        //debug($data);die();
        return $data;
    }
}
?>