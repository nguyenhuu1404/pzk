<?php
$setting = pzk_controller();
$controller = pzk_controller();
$groupByReport = $setting->groupByReport;
$displayReport = $setting->displayReport;
$typeChart = $setting->typeChart;
$configChart = $setting->configChart;
$listFieldSettings = $setting->listFieldSettings;
$sortFields = $setting->sortFields;
$exportFields = $setting->exportFields;
$exportTypes = $setting->exportTypes;
//search
$searchFields = $controller->searchFields;
$Searchlabels = $controller->Searchlabels;
//grid display
$gridDisplay = $controller->gridDisplay;

$keyword = pzk_session($controller->table.'Keyword');
$orderBy = pzk_session($controller->table.'OrderBy');

$showchart = $setting->showchart;

if($exportFields) {
    $data->exportFields = $exportFields;
}
//joins
if ($setting->joins) {
    $data->joins = $setting->joins;
}

//condition
$normalCondition = pzk_session($setting->table.'normalcond');
if($normalCondition) {
    $condition = '';
    foreach($normalCondition as $key => $val) {
        $condition .= $key ." = ". $val.' and ';
    }
    $condition = substr($condition, 0, -5);
    $data->addCondition($condition);
}
$arrCondition = pzk_session($setting->table.'arrcondition');
if($arrCondition) {
    $condition = '';
    foreach($arrCondition as $val) {
        $condition .= $val.' and ';
    }
    $condition = substr($condition, 0, -5);
    $data->addCondition($condition);
}

//group by columns
$groupByColumns = $controller->groupByColumns;
$sessionColumn =  pzk_session($setting->table.'groupByColumns');

//normal group by
$nornalColumn = array();
if($sessionColumn) {
    foreach($sessionColumn as $column => $type){
        if($type == 'normal') {
            $nornalColumn[] = $column;
        }
    }
}

$sessionColumnType = pzk_session($setting->table.'groupByColumnType');
$reportColumns = $controller->reportColumns;

//column is select
$sessionReportColumn = pzk_session($setting->table.'reportColumn');
$sessionShowColumn = pzk_session($setting->table.'showColumn');
$reportColumnActive = $sessionShowColumn.'|'.$sessionReportColumn;

//title show chart
if($reportColumns){
    $title = '';
    foreach($reportColumns as $item) {
        if($item['alias'] == $sessionShowColumn){
            $title = $item['label'];
        }
    }
    $arListReportLable[] = 'Kiểu báo cáo';
    $arListReportLable[] = $title;
    $arListReportValue[] = 'columnName';
    $arListReportValue[] = $sessionShowColumn;
}


//debug($sessionColumn);
//report culumns

$selectFields = '';
$groupBy = array();
$nornalColumnName = '';
$nornalSelect = '';
if(count($nornalColumn)>0) {
    foreach($nornalColumn as $val) {
        $groupBy[]['index'] = $val;
        $nornalColumnName .= "$val, '-' ,";
        $nornalSelect .= "$val, ";
    }
}

if($sessionColumnType and $sessionReportColumn) {
    $concat = '';
    $columnName = '';

    $i = 0;

    foreach ($sessionColumnType as $key => $type) {
        $ucType = ucfirst($type);

        $groupBy[]['index'] = "$key$ucType";

            if($type == 'day') {
                $concat .= "concat($type($key) , '/', month($key) , '/', year($key)) as $key$ucType, ";
                $columnName .= "concat($type($key) , '/', month($key) , '/', year($key)), '-' , ";
            }elseif($type == 'month') {
                $concat .= "concat($type($key) , '/', year($key)) as $key$ucType, ";
                $columnName .= "concat($type($key) , '/', year($key)), '-' , ";
            }
            else {
                $concat .= "$type($key) as $key$ucType, ";
                $columnName .= "$type($key), '-' , ";
            }
    }

    $concat = substr($concat, 0, -2);

    if($nornalColumnName) {
        $tam = $columnName.$nornalColumnName;
        $columnName = substr($tam, 0, -7);
    }else{
        $columnName = substr($columnName, 0, -8);
    }
    $selectFields = "$sessionReportColumn, $concat"." , CONCAT($columnName) as columnName";

}
//select
if ($selectFields) {
        $data->fields = $selectFields;
}else {
    if($nornalSelect && $sessionReportColumn) {
        $nornalSelect = substr($nornalSelect, 0, -2);
        $tmp = "CONCAT($nornalSelect) as columnName";
        $data->fields ="$sessionReportColumn, $tmp";
    }
}
//group by
if ($groupBy) {
    $data->groupByReport = $groupBy;
}else {
    $data->groupByReport = false;
}
//having
if ($setting->having) {
    $data->having = $setting->having;
}
//sort
if($orderBy) {
    $data->orderBy = $orderBy;
}

if($exportFields) {
    $query = $data->stringQueryReport($keyword, $controller->searchFields);
}

$pageSize = pzk_session($setting->table.'PageSize');
if($pageSize) {
    $data->pageSize = $pageSize;
}
$data->pageNum = pzk_request('page');
$countItems = $data->getCountReportItems();

$pages = ceil($countItems / $data->pageSize);
//type chart
if (pzk_session('report_type')) {
    $type = pzk_session('report_type');
} else {
    $type = 'column';
}




//data
$items = $data->getReport($keyword, $controller->searchFields);


$xAxis = false;
if(($showchart && $sessionShowColumn && $sessionColumn && $sessionColumnType) or ($nornalColumn && $sessionReportColumn)) {

    foreach ($items as $val) {
        $arrname[] = $val['columnName'];
    }
    if(isset($arrname)) {
        $category['categories'] = $arrname;
        $xAxis = json_encode($category);
    }


    foreach($items as $val) {
        $arrvalue[] = $val[$sessionShowColumn] + 0; //ep kieu
    }
    if(isset($arrvalue)) {
        $result_arr['data'] = $arrvalue;
        $result_arr['name'] = $title;//$controller->configChart['titley'];
        $a[] = $result_arr;
        $series = json_encode($a);
    }

}
//$data = array(11,10,9,8,12,81);
//$serie1[] = array('name' => 'serie 1', 'data' => $data);
//$serie1[] = array('name' => 'serie 2', 'data' => $data);
//$a = json_encode($serie1);
//echo $a;
?>
<div class="col-xs-2">
<style>
    .ui-datepicker{z-index:1151 !important;}
</style>
        <!-- search, filter, sort -->
<?php if($sortFields or $searchFields) { ?>
        <div class="well well-sm">
            <form role="search" action="{url /admin}_{controller.module}/searchFilter">
                <div class="row">
                    <?php if($searchFields) {
                        ?>
                        <div class="form-group col-xs-12">
                            <label>Tìm theo  </label><br />
                            <input type="text" name="keyword" class="form-control" placeholder="<?php if($Searchlabels){ echo $Searchlabels; } ?>" value="{keyword}" />
                        </div>
                    <?Php } ?>
                    <?php if($sortFields) { ?>
                        <div class="form-group col-xs-12">
                            <label>Sắp xếp</label><br />
                            <select id="orderBy" name="orderBy" class="form-control" placeholder="Sắp xếp theo" onchange="window.location='{url /admin}_{controller.module}/changeOrderBy?orderBy=' + this.value;">
                                <?php foreach ($sortFields as $value => $label){ ?>
                                    <option value="{value}">{label}</option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#orderBy').val('{orderBy}');
                            </script>
                        </div>
                    <?php } ?>

                    <?php if($searchFields) { ?>
                        <div style="width: 12%;" class="form-group col-xs-12">
                            <label>&nbsp;</label><br />
                            <button type="submit" value="<?php echo ACTION_SEARCH; ?>" name="submit_action" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search"></span> Tìm kiếm</button>
                        </div>
                    <?php } ?>
                    <div  class="form-group col-xs-12">
                        <label>&nbsp;</label><br />
                        <button type="submit" value="<?php echo ACTION_RESET; ?>" name="submit_action" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
                    </div>

                </div>
            </form>

        </div><!-- end well -->
<?php } ?>
        <!-- end search, filter, sort -->
        <!-- report -->
        <div class="well well-sm">
            <form role="search" action="{url /admin}_{controller.module}/delSessionReport">
                <div class="row">
                    <?php if($reportColumns) { ?>
                        <div class="form-group col-xs-12">
                            <label style="width: 110px;">Lọc theo</label>
                            <div class="form-group col-xs-12">
                                <select class="form-control" id="reportColumns" name="reportColumns" onchange="window.location='{url /admin}_{controller.module}/reportColumn?reportColumn=' + this.value;" >
                                    <?php foreach($reportColumns as $colum) { ?>
                                        <option value="{colum[alias]}|<?php echo $colum['type']."(".$colum['index'].") as ".$colum['alias'];?>">{colum[label]}</option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#reportColumns').val("<?php echo $reportColumnActive; ?>");
                                </script>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    if($groupByColumns) { ?>
                        <div class="form-group col-xs-12">
                            <label style="width: 110px;">Báo cáo theo: </label>

                            <?php $arrDate = pzk_session($setting->table.'arrdate');?>

                            <?php foreach ($groupByColumns as $value){ ?>
                                <div class="form-group col-xs-12">
                                    <input value="{value[index]}|{value[type]}" <?php if(isset($sessionColumn[$value['index']])){ echo 'checked'; } ?> onchange="window.location='{url /admin}_{controller.module}/changeGroupByColumns?groupByColumns=' + this.value + '&groupByColumnCheck=' + (this.checked?'1':'0');" type="checkbox" name="{value['index']}"><?php echo $value['label']; ?>
                                    <?php
                                    if(isset($value['formatType']) && count($value['formatType']) >0) {
                                        ?>
                                        <select id="gc{value[index]}" name="gc{value[index]}" class="form-control" placeholder="Sắp xếp theo" onchange="window.location='{url /admin}_{controller.module}/changeGroupByColumnTypes?groupByColumn={value[index]}&groupByColumnType=' + this.value;">
                                            <?php foreach($value['formatType'] as $key =>$val) { ?>
                                                <option value="{key}">{val}</option>
                                            <?php } ?>
                                        </select>
                                    <?php
                                    if($arrDate) {
                                        $todate = @$arrDate["date" . $value['index']]['todate'];

                                        $fromdate = @$arrDate["date" . $value['index']]['fromdate'];
                                    }
                                    ?>
                                        From: <input id="from{value[index]}"  name="from{value[index]}" type='text' class="form-control datepicker" value="{fromdate}" />
                                        To: <input id="to{value[index]}"  name="to{value[index]}" type='text' class="form-control datepicker" value="{todate}"/>
                                        <button  onclick="updateCondition('{value[index]}');return false;" class="btn btn-default btn-sm">Update Filter</button>
                                        <button  onclick="delCondition('{value[index]}');return false;" class="btn btn-default btn-sm">Bo Filter</button>


                                        <script type="text/javascript">

                                            $(function () {

                                                $(".datepicker").datetimepicker({
                                                    dateFormat: 'yy-mm-dd',
                                                    timeFormat: 'HH:mm:ss'
                                                });
                                            });
                                        </script>

                                        <script type="text/javascript">
                                            $('#gc{value[index]}').val("<?php echo $sessionColumnType[$value['index']]; ?>");
                                        </script>
                                    <?php } ?>
                                    <?php if(isset($value['condition']) && count($value['condition']) >0) {
                                        $tablecon = $value['condition']['table'];
                                        $valuecon = $value['condition']['value'];
                                        $showcon = $value['condition']['show'];
                                        $selectcon = $valuecon.', '.$showcon;
                                        $datacon = _db()->useCB()->select($selectcon)->from($tablecon)->result();
                                        ?>
                                        <select id="nc{value[index]}" onchange="window.location='{url /admin}_{controller.module}/changeNormalCondition?column={value[index]}&value=' + this.value;" class="form-control hiden" placeholder="Sắp xếp theo">
                                            <option value="">Chọn tất</option>
                                            <?php foreach($datacon as $val) { ?>
                                                <option value="<?php echo $val[$valuecon]; ?>"><?php echo $val[$showcon]; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php $check = @$normalCondition[$value['index']]; ?>
                                        <script type="text/javascript">
                                            $('#nc{value[index]}').val('{check}');
                                        </script>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                        </div>
                    <?php } ?>

                </div>
            </form>

        </div><!-- end well -->
<script>
    function updateCondition(column) {
        var todate = $('#to'+column).val();
        var fromdate = $('#from'+column).val();
        if(todate && fromdate) {
            $.ajax({
                method: "POST",
                url: BASE_REQUEST+"/admin_"+"{setting.module}"+"/fillterReport",
                data: { column: column, todate: todate, fromdate:fromdate }
            }).done(function( msg ) {
                if(msg == 1) {
                    location.href= BASE_REQUEST+"/admin_"+"{setting.module}"+"/index";
                }else {
                    alert( msg );
                }

            });
        }
        return false;
    }

    function delCondition(column) {
        $.ajax({
            method: "POST",
            url: BASE_REQUEST+"/admin_"+"{setting.module}"+"/delCondition",
            data: { column: column }
        }).done(function( msg ) {
            location.href= BASE_REQUEST+"/admin_"+"{setting.module}"+"/index";
        });
        return false;
    }
</script>
</div>
<div class="col-xs-10">


<?php if($showchart &&  $xAxis) { ?>

            <script type="text/javascript">

                $(function () {
                    // Set up the chart
                    var chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'container',
                            type: "<?php echo $type; ?>",
                            margin: 75
                        },
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: "<?php echo 'Báo cáo';//$title;//$configChart['title']; ?>"
                        },
                        subtitle: {
                            text: "<?php echo $title;//$configChart['subtitle']; ?>"
                        },
                        xAxis: <?php echo $xAxis; ?>,
                        plotOptions: {
                            column: {
                                depth: 25
                            }
                        },
                        yAxis: {
                            title: {
                                text: "<?php echo $title;//$configChart['titley']; ?>"
                            },
                            plotLines: [
                                {
                                    value: 0,
                                    width: 1,
                                    color: '#808080'
                                }
                            ]
                        },

                        series: <?php echo $series; ?>
                    });


                });
            </script>

            <div class="well">
                <div class="row">
                    <div class="form-group col-xs-3">
                        <label>Chọn loại biểu đồ</label><br />
                        <select class="form-control" id="type" name="type"
                                onchange="window.location='{url /admin}_{setting.module}/highchart?type=' + this.value;">
                            {each $typeChart as $item }
                            <option value="{item[value]}">{item[index]}</option>
                            {/each}
                        </select>
                        <script type="text/javascript">
                            <?php $select = pzk_session('report_type'); ?>
                            $('#type').val('{select}');
                        </script>
                    </div>
                </div>

            </div>

            <div  id="container"></div>
<?php } ?>
    <!-- report -->
    <?php if($nornalSelect or $selectFields) {  ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <b><?php echo $setting->title; ?></b>
            </div>
            <table class="table table-hover">
                <tr>
                    {each $arListReportLable as $val}
                    <th>{val}</th>
                    {/each}
                </tr>
                <?php if($items) {  ?>
                    {each $items as $item}

                    <tr>
                        {each $arListReportValue as $val}

                        <td><?php echo $item[$val]; ?></td>
                        {/each}
                    </tr>
                    {/each}
                <?php } ?>
                <tr>
                    <td colspan="8">
                        <form class="form-inline" role="form">
                            <strong>Số mục: </strong>
                            <select id="pageSize" name="pageSize" class="form-control input-sm" placeholder="Số mục / trang" onchange="window.location='{url /admin}_{setting.module}/changePageSize?pageSize=' + this.value;">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                            <script type="text/javascript">
                                $('#pageSize').val('{pageSize}');
                            </script>
                            <strong>Trang: </strong>
                            <?php for ($page = 0; $page < $pages; $page++) {
                                if($page == $data->pageNum) { $btn = 'btn-primary'; }
                                else { $btn = 'btn-default'; }
                                ?>
                                <a class="btn btn-xs {btn}" href="{url /admin}_{setting.module}/index?page={page}">{? echo ($page + 1)?}</a>
                            <?php } ?>
                        </form>

                    </td>
                </tr>

            </table>

            <div class="panel-footer item">
                <?php
                if($exportTypes && $exportFields) {
                    $time = $_SERVER['REQUEST_TIME'];
                    $username = pzk_session('adminUser');
                    if(!$username) $username = 'ongkien';
                    $token = md5($time.$username . 'onghuu');
                    ?>
                    <form id="fromexport"  class="col-md-3 pull-right" action="/export.php?token={token}&time={time}" method="post">
                        <input type="hidden" name="q" value="<?php echo base64_encode(encrypt($query, SECRETKEY)); ?>" />
                        <input type="hidden" name="exportFields" value="<?php echo implode(',', $exportFields); ?>"/>
                        <select style="border: 1px solid #ccc;" class="btn" name="type">
                            {each $exportTypes as $val}
                            <option value="{val}">Export {val}</option>
                            {/each}
                        </select>
                        <div id="exportdata" class="btn  btn-sm pull-right btn-success ">
                            <span class="glyphicon glyphicon-export"></span>
                            Export
                        </div>

                    </form>
                <?php } ?>

            </div>
        </div>
        <?php } ?>
    <!--endtable-->
</div>


