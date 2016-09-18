<?php
pzk_import('core.db.List');
class PzkCoreDbGrid extends PzkCoreDbList {
    public $joins = false;
    public $scriptable = true;
    public function prepareQuery($query) {
        if(is_string($this->joins))
            $this->joins = json_decode($this->joins, true);
        $join = $this->joins;
        if($join) {
            foreach($join as $val) {
                $query->join($val['table'], $val['condition'], $val['type']);
            }
        }
    }
}
?>