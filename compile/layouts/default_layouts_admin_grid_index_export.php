<?php
$exportFields = $data->getExportFields();
$exportTypes = $data->getExportTypes();
$searchFields = $data->getSearchFields();
$keyword = $data->getKeyword();
        if($exportTypes && $exportFields) {
        	$query = $data->getParent()->stringQuery($keyword, $searchFields);
        	$time = $_SERVER['REQUEST_TIME'];
            $username = pzk_session()->getAdminUser();
            if(!$username) $username = 'ongkien';
            $token = md5($time.$username . 'onghuu');
            ?>
            <form id="exportForm"  class="col-md-3 pull-right" action="<?php echo  BASE_URL; ?>/export.php?token=<?php echo isset($token)?$token: '';?>&time=<?php echo isset($time)?$time: '';?>" method="post">
                <input type="hidden" name="q" value="<?php echo base64_encode(encrypt($query, 'onghuu')); ?>" />
                <input type="hidden" name="exportFields" value="<?php echo implode(',', $exportFields); ?>"/>
                <select style="border: 1px solid #ccc;" class="btn" name="type">
                    <?php foreach ( $exportTypes as $val ) : ?>
                    <option value="<?php echo isset($val)?$val: '';?>">Export <?php echo isset($val)?$val: '';?></option>
                    <?php endforeach; ?>
                </select>
                <div id="exportdata" class="btn  btn-sm pull-right btn-success ">
                    <span class="glyphicon glyphicon-export"></span>
                    Export
                </div>

            </form>
        <?php } ?>