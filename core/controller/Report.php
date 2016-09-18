<?php
class PzkReportController extends PzkGridAdminController {
    public $masterStructure = 'admin/home/index';
    public $masterPosition = 'left';
    public $scriptTo = 'head';
    public $customModule = 'report';
    public $module = 'report';
    public $selectFields = '*';
    public $Searchlabels = false;
    public $groupBy = false;
    public $having = false;
    public $groupByReport = false;
    public $listFieldSettings = false;
    public $sortFields = false;
    public $showchart = false;
    public $displayReport = false;
    public $typeChart = false;
    public $title = false;
    public $gridDisplay = false;
    public $groupBycolumns = false;
    public $reportColumns = false;

    public function highchartAction() {
        pzk_session('report_type', pzk_request('type'));

        $this->redirect('index');
    }

    public function changeGroupByColumnsAction() {
        $columnType = explode('|', pzk_request('groupByColumns'));
        $column = $columnType[0];
        $type = $columnType[1];
        $ColumnCheck = pzk_request('groupByColumnCheck');
        if($ColumnCheck)  {
            $arrGroupByColumns = pzk_session($this->table.'groupByColumns');
            $arrGroupByColumns[$column] = $type;
            pzk_session($this->table.'groupByColumns', $arrGroupByColumns);

        }  else {

            $arrGroupByColumns = pzk_session($this->table.'groupByColumns');
            //xoa condition
            $arrCondition = pzk_session($this->table.'arrcondition');
            unset($arrCondition[$column]);
            pzk_session($this->table.'arrcondition', $arrCondition);
            //xoa date
            $arrDate = pzk_session($this->table.'arrdate');
            unset($arrDate["date".$column]);
            pzk_session($this->table.'arrdate', $arrDate);


            //array group bay
            $check = $arrGroupByColumns[$column];
            if($check) {
                unset($arrGroupByColumns[$column]);
                pzk_session($this->table.'groupByColumns', $arrGroupByColumns);
            }
            //array column type
            $arrGroupByColumnTypes = pzk_session($this->table.'groupByColumnType');
            $checktype = $arrGroupByColumnTypes[$column];
            if($checktype) {
                unset($arrGroupByColumnTypes[$column]);
                pzk_session($this->table.'groupByColumnType', $arrGroupByColumnTypes);
            }


        }

        $this->redirect('index');
    }

    public function changeGroupByColumnTypesAction() {
        $groupByColumn = pzk_request('groupByColumn');
        $groupByColumnType = pzk_request('groupByColumnType');

        $arrGroupByColumnTypes = pzk_session($this->table.'groupByColumnType');
        $arrGroupByColumnTypes[$groupByColumn] = $groupByColumnType;
        pzk_session($this->table.'groupByColumnType', $arrGroupByColumnTypes);

        $this->redirect('index');

    }
    public function reportColumnAction() {
        $report = pzk_request('reportColumn');
        $arrR = explode('|', $report);
        $reportColumn = $arrR[1];
        $showColumn = $arrR[0];
        pzk_session($this->table.'reportColumn', $reportColumn);
        pzk_session($this->table.'showColumn', $showColumn);

        $this->redirect('index');
    }
    public function fillterReportAction() {
        $column = pzk_request('column');
        $toDate = pzk_request('todate');
        $fromDate = pzk_request('fromdate');
        $arrGroupByColumnTypes = pzk_session($this->table.'groupByColumnType');
        $type = @$arrGroupByColumnTypes[$column];
        $arrCondition = pzk_session($this->table.'arrcondition');
        $arrDate = pzk_session($this->table.'arrdate');
        if(isset($type)) {
            $condition = "'$fromDate' < `$column` and `$column` < '$toDate'";
            $date = array(
                "todate"=>$toDate,
                "fromdate"=>$fromDate
            );
            $arrDate["date$column"]= $date;
            $arrCondition[$column]= $condition;
            pzk_session($this->table.'arrdate', $arrDate);
            pzk_session($this->table.'arrcondition', $arrCondition);

            echo 1;
        }else{
            echo 'Ban phai chon '.$column;
        }

    }
    public function delConditionAction() {
        $column = pzk_request('column');
        $arrCondition = pzk_session($this->table.'arrcondition');
        $arrDate = pzk_session($this->table.'arrdate');
        if($arrCondition && $arrDate) {
            //xoa condition
            unset($arrCondition[$column]);
            pzk_session($this->table.'arrcondition', $arrCondition);
            //xoa date
            unset($arrDate["date".$column]);
            pzk_session($this->table.'arrdate', $arrDate);
        }

    }
    public function changeNormalConditionAction() {
        $column = pzk_request('column');
        $value = pzk_request('value');
        $normalCondition = pzk_session($this->table.'normalcond');
        if($value) {
            $normalCondition[$column] = $value;
            pzk_session($this->table.'normalcond', $normalCondition);

        }else {
            unset($normalCondition[$column]);
            pzk_session($this->table.'normalcond', $normalCondition);
        }
        $this->redirect('index');
    }
}
?>