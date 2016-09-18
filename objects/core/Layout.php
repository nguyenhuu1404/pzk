<?php
class PzkCoreLayout extends PzkObject {
    public $layout='layout';
    public function add($obj, $colIndex) {
        if(!isset($this->$colIndex)) $this->$colIndex = array();
        $this->{$colIndex}[] = $obj;

    }
    public function displayObjects($colIndex) {
        if(isset($this->$colIndex))
        foreach($this->$colIndex as $obj) {
            $obj->display();
        }
    }
}