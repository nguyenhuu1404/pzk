<div class="grid">
	<?php for($i = 0; $i < $data['rows']; $i++) {?>
		<?php for($j = 0; $j < $data['columns']; $j++) {?>
			<div class="cell-<?php echo $i?>-<?php echo $j?>"><?php $this->displayChildren("[pos=cell-$i-$j]")?></div>
		<?php }?>
	<?php }?>
</div>