<?php
pzk_loader()->importObject('core/db/Grid');
/**
 *
 */
class PzkCoreDbReport extends PzkCoreDbGrid {
    public $scriptTo = 'head';
    public $orderBy = false;
    public $joins = false;

    public function init() {
        if (@$this->scriptTo && $scriptToElement = pzk_element($this->scriptTo)) {
            $scriptToElement->append(pzk_parse('<html.js src="/3rdparty/highchart/js/highcharts.js" />'));
            $scriptToElement->append(pzk_parse('<html.js src="/3rdparty/highchart/js/modules/exporting.js" />'));
        }
        $this->conditions = json_decode($this->conditions, true);
        if($this->parentMode && $this->parentMode !== 'false') {
            if(!$this->parentId) {
                $request = pzk_element('request');
                $this->parentId = $request->getSegment(3);
            }
            $this->conditions = array('and', $this->conditions, array($this->parentField, $this->parentId));
        }
    }

    public function getReport($keyword = NULL, $fields = array()){
        $query = _db()->useCB()->select($this->fields)->from($this->table)
            ->where($this->conditions)
            ->orderBy($this->orderBy)
            ->limit($this->pageSize, $this->pageNum);
        if($keyword && count($fields)) {
            $conds = array('or');
            foreach($fields as $field) {
                $conds[] = array('like', $field, "%$keyword%");
            }
            $query->where($conds);
        }
        $this->processGroupBy($query);
        $this->prepareQuery($query);
        //echo $query->getQuery();

        return $query->result();
    }

    public function getCountReportItems($keyword = NULL, $fields = array()) {
        $row = _db()->useCB()->select($this->fields)
            ->from($this->table)
            ->where($this->conditions);
        if($keyword && count($fields)) {
            $conds = array('or');
            foreach($fields as $field) {
                $conds[] = array('like', $field, "%$keyword%");
            }
            $row->where($conds);
        }
        $this->processGroupBy($row);
        $this->prepareQuery($row);
        $row = $row->result();
        return count($row);
    }


    public function processGroupBy($query) {
        $arrGroupBy = $this->groupByReport;
        if($arrGroupBy) {
            $groupBy = '';
            foreach($arrGroupBy as $item) {
                $groupBy .= $item['index'].', ';
            }
            $query->groupBy(substr($groupBy, 0, -2))
                ->having($this->having);
        }
    }

    public function stringQueryReport ($keyword = NULL, $fields = array()) {
        $query = _db()->useCB()->select($this->fields)->from($this->table)
            ->where($this->conditions)
            ->orderBy($this->orderBy)
            ->limit($this->pageSize, $this->pageNum);
            if($keyword && count($fields)) {
                $conds = array('or');
                foreach($fields as $field) {
                    $conds[] = array('like', $field, "%$keyword%");
                }
                $query->where($conds);
            }
            $this->processGroupBy($query);
            $this->prepareQuery($query);

        return $query->getQuery();
    }


}
?>