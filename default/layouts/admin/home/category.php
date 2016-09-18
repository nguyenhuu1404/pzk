<?php 
	$category = $data->getItems();
	
	$cateParent = treefy($category,'parent',0);
	if($cateParent) {
 ?>
<label for="">Categories</label><br />
	{each $cateParent as $value}
	<?php 
		$tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
		if($value['id'] == $data->rootId) {
			$value['name'] = '<b>' . $value['name'] . '</b>';
		}
		if($value['level'] == 1){
			$cate = $tab.$value['name'];
		} else {
			for ($i= 2; $i <= $value['level'] ; $i++) { 
				$tab = $tab.$tab;
			}
			
			$cate = $tab.$value['name'];
		}
	 ?>
	<a href="/admin_home/category/{value[id]}" style="text-decoration: none;"><?php echo $cate; ?></a><br />
	{/each}
<?php } ?>