{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 	12);
$mdsize 	= pzk_or($data->getMdsize(), 	12);
?}

<div class="col-xs-{xssize} col-md-{mdsize}">
	<div class="form-group clearfix">
		<label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
		<select
			class="form-control" id="{data.getIndex()}{rand}"
			name="{data.getIndex()}">
        <?php
								$allControllers = array ();
								$arrcontroller = glob ( BASE_DIR . '/app/' . pzk_app ()->getPathByName () . '/controller/admin/*.php' );
								$subs = glob ( BASE_DIR . '/app/' . pzk_app ()->getPathByName () . '/controller/admin/*/*.php' );
								$arrSubController = array ();
								foreach ( $subs as $sub ) {
									$arrsub = explode ( '/', $sub );
									$countarr = count ( $arrsub );
									$arrSubController [] = strtolower ( $arrsub [$countarr - 2] ) . '_' . strtolower ( substr ( end ( $arrsub ), 0, - 4 ) );
								}
								
								?>
        <option
				value="<?php if(pzk_request('action') =='add') { echo '0_'.time(); } elseif(substr($data->getValue(), 0, 2) == '0_') { echo $data->getValue(); } ?>">Chọn
				controller</option>
		{each $arrcontroller as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		{/each}
        {each $arrSubController as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option>
        {/each}
		<?php
		$arrcontroller = glob ( BASE_DIR . '/app/' . pzk_app ()->getPackageByName () . '/controller/admin/*.php' );
		$subs = glob ( BASE_DIR . '/app/' . pzk_app ()->getPackageByName () . '/controller/admin/*/*.php' );
		$arrSubController = array ();
		foreach ( $subs as $sub ) {
			$arrsub = explode ( '/', $sub );
			$countarr = count ( $arrsub );
			$arrSubController [] = strtolower ( $arrsub [$countarr - 2] ) . '_' . strtolower ( substr ( end ( $arrsub ), 0, - 4 ) );
		}
		
		?>
		{each $arrcontroller as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		{/each}
        {each $arrSubController as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option>
        {/each}
		<?php
		$arrcontroller = glob ( BASE_DIR . '/default/controller/admin/*.php' );
		$subs = glob ( BASE_DIR . '/default/controller/admin/*/*.php' );
		$arrSubController = array ();
		foreach ( $subs as $sub ) {
			$arrsub = explode ( '/', $sub );
			$countarr = count ( $arrsub );
			$arrSubController [] = strtolower ( $arrsub [$countarr - 2] ) . '_' . strtolower ( substr ( end ( $arrsub ), 0, - 4 ) );
		}
		
		?>
		{each $arrcontroller as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		{/each}
        {each $arrSubController as $val }
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option> {/each}
		</select>
		<script type="text/javascript">
		
			//$("#{data.getIndex()}{rand}").val("<?php echo $data->getValue(); ?>").change();
			
			//$('#{data.getIndex()}{rand}').val('{data.getValue()}');
			
			var my_options = $("#{data.getIndex()}{rand} option");
			//var selected = $("#{data.getIndex()}{rand}").val(); /* preserving original selection, step 1 */

			my_options.sort(function(a,b) {
				if (a.text > b.text) return 1;
				else if (a.text < b.text) return -1;
				else return 0
			})

			$("#{data.getIndex()}{rand}").empty().append( my_options );
			$("#{data.getIndex()}{rand} option").each(function(){
			  $(this).siblings("[value="+ this.value+"]").remove();
			});
			//$("#{data.getIndex()}{rand}").val(selected); /* preserving original selection, step 2 */
		</script>
	</div>
</div>
<script>
	$("#{data.getIndex()}{rand}").val("<?php echo $data->getValue(); ?>");
		
</script>
