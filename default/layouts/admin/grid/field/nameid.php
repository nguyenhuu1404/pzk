<?php
    $table = $data->getTable();
    $findField = $data->getFindField();
    $showField = $data->getShowField();

    $Ids = $data->getValue();
    $name = '';
    if(is_string($Ids) && $Ids) {
        $arrIds = explode(',', trim($Ids, ','));
        if($arrIds) {
            $arrAllField = _db()->useCache(1800)->select('*')->from($table)->result();
            foreach($arrAllField as $item) {
                if(in_array($item[$findField], $arrIds)){
                    $name .= $item[$showField].', ';
                }
            }
            $name = substr($name,0,-2);
        }
    }elseif(is_int($Ids) && $Ids) {
        $name = _db()->useCache(1800)->select('*')->from($table)->where(array($findField, $Ids))->result_one();
        $name = $name[$showField];
    }
?>
<div style="width: 200px;"><?php echo $name; ?></div>