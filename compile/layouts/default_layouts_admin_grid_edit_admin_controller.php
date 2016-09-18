<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 	12);
$mdsize 	= pzk_or($data->getMdsize(), 	12);
?>

<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
	<div class="form-group clearfix">
		<label for="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"><?php echo isset($data)?$data->getLabel(): '';?></label>
		<select
			class="form-control" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>"
			name="<?php echo isset($data)?$data->getIndex(): '';?>">
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
		<?php foreach ( $arrcontroller as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		<?php endforeach; ?>
        <?php foreach ( $arrSubController as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option>
        <?php endforeach; ?>
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
		<?php foreach ( $arrcontroller as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		<?php endforeach; ?>
        <?php foreach ( $arrSubController as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option>
        <?php endforeach; ?>
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
		<?php foreach ( $arrcontroller as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
		<option
				value="<?php echo 'admin_'.strtolower(basename($val,".php"));  ?>">
				<?php echo 'admin_'.strtolower(basename($val,".php"));  ?></option>
		<?php endforeach; ?>
        <?php foreach ( $arrSubController as $val  ) : ?>
		<?php if (!isset($allControllers[$val])) { $allControllers[$val] = true; } else { continue; } ?>
        <option value="<?php echo 'admin_'.$val;  ?>">
            <?php echo 'admin_'.$val;  ?></option> <?php endforeach; ?>
		</select>
		<script type="text/javascript">
		
			//$("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").val("<?php echo $data->getValue(); ?>").change();
			
			//$('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($data)?$data->getValue(): '';?>');
			
			var my_options = $("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?> option");
			//var selected = $("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").val(); /* preserving original selection, step 1 */

			my_options.sort(function(a,b) {
				if (a.text > b.text) return 1;
				else if (a.text < b.text) return -1;
				else return 0
			})

			$("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").empty().append( my_options );
			$("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?> option").each(function(){
			  $(this).siblings("[value="+ this.value+"]").remove();
			});
			//$("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").val(selected); /* preserving original selection, step 2 */
		</script>
	</div>
</div>
<script>
	$("#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>").val("<?php echo $data->getValue(); ?>");
		
</script>
