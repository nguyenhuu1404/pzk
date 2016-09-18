<?php
$controller = pzk_request('controller');
$action = pzk_request('action');
$setting = pzk_controller();
$config = pzk_request()->getConfig();
?>

<ul class="nav nav-pills">
	<li class="panel-default">
        <div class="panel-heading"><b>Cấu hình</b></div>
    </li>
    <?php
    if($setting->getMenuLinks()) {
        foreach($setting->getMenuLinks() as $val) {
            $tam = explode('=', $val['href']);
            $linkaction = end($tam);
            ?>
			<li class="<?php if($config == $linkaction) { echo 'active'; } ?>">
            <a href="<?php echo isset($val['href'])?$val['href']: '';?>"><?php echo isset($val['name'])?$val['name']: '';?></a>
			</li>
		<?php
        }
    }
    ?>
</ul>
<br />