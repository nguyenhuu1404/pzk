<?php 
$roles = $data->getRoles();
$menus = $data->getMenus();
$privileges = $data->getPrivileges();
$menus = treefy($menus);
$tab = '|&nbsp;&nbsp;&nbsp;&nbsp;';
$icons	= array(
	'add'	=> 'plus',
	'edit'	=>	'edit',
	'del'	=>	'remove',
	'index'	=>	'list',
	'details'	=>	'eye-open'
);
$hasRoles	=	array();
$allPrivileges 	= $data->getAllAdminLevelAction();
foreach($allPrivileges as $privRow)	{
	$hasRoles[$privRow['action_type']][$privRow['admin_action']][$privRow['admin_level']] = true;
}
?>
<style type="text/css">
table .header-fixed {
  position: fixed;
  top: 40px;
  z-index: 1020; /* 10 less than .navbar-fixed to prevent any overlap */
  border-bottom: 1px solid #d5d5d5;
  -webkit-border-radius: 0;
     -moz-border-radius: 0;
          border-radius: 0;
  -webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
     -moz-box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
          box-shadow: inset 0 1px 0 #fff, 0 1px 5px rgba(0,0,0,.1);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false); /* IE6-9 */
}
</style>
<script type="text/javascript">
(function($) {

$.fn.fixedHeader = function (options) {
 var config = {
   topOffset: 40,
   bgColor: '#EEEEEE'
 };
 if (options){ $.extend(config, options); }

 return this.each( function() {
  var o = $(this);

  var $win = $(window)
    , $head = $('thead.header', o)
    , isFixed = 0;
  var headTop = $head.length && $head.offset().top - config.topOffset;

  function processScroll() {
    if (!o.is(':visible')) return;
    var i, scrollTop = $win.scrollTop();
    var t = $head.length && $head.offset().top - config.topOffset;
    if (!isFixed && headTop != t) { headTop = t; }
    if      (scrollTop >= headTop && !isFixed) { isFixed = 1; }
    else if (scrollTop <= headTop && isFixed) { isFixed = 0; }
    isFixed ? $('thead.header-copy', o).removeClass('hide')
            : $('thead.header-copy', o).addClass('hide');
  }
  $win.on('scroll', processScroll);

  // hack sad times - holdover until rewrite for 2.1
  $head.on('click', function () {
    if (!isFixed) setTimeout(function () {  $win.scrollTop($win.scrollTop() - 47) }, 10);
  })

  $head.clone().removeClass('header').addClass('header-copy header-fixed').appendTo(o);
  var ww = [];
  o.find('thead.header > tr:first > th').each(function (i, h){
    ww.push($(h).width());
  });
  $.each(ww, function (i, w){
    o.find('thead.header > tr > th:eq('+i+'), thead.header-copy > tr > th:eq('+i+')').css({width: w});
  });

  o.find('thead.header-copy').css({ margin:'0 auto',
                                    width: o.width(),
                                   'background-color':config.bgColor });
  processScroll();
 });
};

})(jQuery);
</script>
<div class="container">
	<table class="table-fixed-header">
	<thead class="header">
	<tr>
		<th>Danh mục</th>
		<?php foreach ( $roles as $role ) : ?>
		<th><?php echo isset($role['level'])?$role['level']: '';?></th>
		<?php endforeach; ?>
	</tr>
	</thead>
	
	<tbody>
	<?php foreach ( $menus as $menu ) : ?>
	<?php	$tabs = rtrim(str_repeat($tab, $menu['level']), '&nbsp;'); ?>
		<tr>
			<td><?php echo isset($tabs)?$tabs: '';?>__<?php echo isset($menu['name'])?$menu['name']: '';?></td>
			<?php foreach ( $roles as $role ) : ?>
			
			<td>
			<?php if(strpos($menu['admin_controller'], '0_') === false): ?>
			<?php foreach ( $privileges as $priv ) : ?> 
			<?php 
			$hasRole = @$hasRoles[$priv][$menu['admin_controller']][$role['level']];
			if($hasRole) {
				$style	='color: blue;';
			} else {
				$style	='';
			}
			?>
			<span id="priv-<?php echo isset($priv)?$priv: '';?>-<?php echo isset($menu['admin_controller'])?$menu['admin_controller']: '';?>-<?php echo isset($role['level'])?$role['level']: '';?>" class="glyphicon glyphicon-<?php echo $icons[$priv]?>" style="<?php echo isset($style)?$style: '';?>" title="<?php echo isset($priv)?$priv: '';?>" onclick="privilege_toggle('<?php echo isset($priv)?$priv: '';?>','<?php echo isset($menu['admin_controller'])?$menu['admin_controller']: '';?>', '<?php echo isset($role['level'])?$role['level']: '';?>');" ></span> <?php endforeach; ?>
			<?php else: ?>
			<?php 
			$hasRole = @$hasRoles['index'][$menu['admin_controller']][$role['level']];
			if($hasRole) {
				$style	='color: blue;';
			} else {
				$style	='';
			}
			?>
			<span id="priv-index-<?php echo isset($menu['admin_controller'])?$menu['admin_controller']: '';?>-<?php echo isset($role['level'])?$role['level']: '';?>" class="priv-index glyphicon glyphicon-<?php echo $icons['index']?>" style="<?php echo isset($style)?$style: '';?>" title="index" onclick="privilege_toggle('index','<?php echo isset($menu['admin_controller'])?$menu['admin_controller']: '';?>', '<?php echo isset($role['level'])?$role['level']: '';?>');" ></span>
			<?php endif; ?>
			</td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>

<script type="text/javascript">
function privilege_toggle(action, controller, role) {
	$.ajax({
		url:'/admin_privilege/edit',
		data: {
			admin_action:		action,
			admin_controller:	controller,
			role:		role
		},
		type: 'post',
		success: function(resp) {
			if(resp == '1')	{
				$('#priv-' + action+'-'+controller+'-'+role).css('color', 'blue');
			} else {
				$('#priv-' + action+'-'+controller+'-'+role).css('color', 'black');
			}
		}
	});
}
$(function() {
	$('.table-fixed-header').fixedHeader();
});
</script>