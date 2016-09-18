<?php
    $level = pzk_session('adminLevel');
	$allmenu = $data->getDataMenu($level);
?>
<div id="menu">
	<ul class="drop">
		<li style="background: #fff;"><a style="background: #fff;" href="#" onclick="return false;"><img style="height: 32px; width: auto;" src="<?php echo BASE_URL ?>/default/skin/admin/media_admin/logo.png" alt="Logo" /></a></li>
		<li><a href="/admin_home/index"> Bảng điều khiển</a></li>
    </ul>
    <?php
    $items = buildTree($allmenu);
    showAdminMenu($items);
    ?>
	<ul class="drop" style="float: right;">
		<li><a href="#"><?=pzk_session('adminUser')?> </a></li>
		<li> <a style="float: right;" href="/admin_login/logout"><b>(Thoát)</b></a></li>
	</ul>
</div>
<div id="main">