		
		
		<?php 
		$controller = pzk_controller();
		$filterFields = $data->getFilterFields ();
		if ($filterFields) :?>
			<?php foreach ( $filterFields as $field ) :?>
				<?php $rand = rand(0, 100000);?>
				<?php if ($field ['type'] == 'status') : ?>
					<span class="hidden"><?php echo isset($field['label'])?$field['label']: '';?></span>
					<select id="<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>"
						name="<?php echo isset($field['index'])?$field['index']: '';?>"
						onchange="pzk_list.filter('<?php echo isset($field['type'])?$field['type']: '';?>', '<?php echo isset($field['index'])?$field['index']: '';?>', this.value);">
						<option value="">Tất cả</option>
						<option value="0">Chưa kích hoạt</option>
						<option value="1">kích hoạt</option>
	
					</select>
					<script type="text/javascript">
	                	<?php $status = $controller->getFilterSession()->get($field['index']); ?>
	                    $('#<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($status)?$status: '';?>');
	                </script>
                <?php  elseif($field['type'] == 'select') : ?>
						<span class="hidden"><?php echo isset($field['label'])?$field['label']: '';?></span>
						<select id="<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($field['index'])?$field['index']: '';?>" onchange="pzk_list.filter('<?php echo isset($field['type'])?$field['type']: '';?>', '<?php echo isset($field['index'])?$field['index']: '';?>', this.value);">
                            <?php
						$parents = _db ()->select ( '*' )->from ( $field ['table'] )->where(pzk_or(@$field['condition'], '1'))->result ();
							if (isset ( $parents [0] ['parent'] )) {
								$parents = treefy ( $parents, 'parent', 0 );
								echo "<option value='' >--Tất cả</option>";
							} else {
								echo "<option value=''>Tất cả</option>";
							}
							?>
							<?php if(isset($field['notAccept']) && $field['notAccept'] == '1'):?>
								<option value='0'>(Trống)</option>
							<?php endif;?>
                            <?php foreach ( $parents as $parent ) : ?>
                            <option value="<?php echo $parent[$field['show_value']]; ?>"><?php if(isset($parent['parent'])){ echo str_repeat('--', @$parent['level']); } ?>
                                <?php echo $parent[$field['show_name']]; ?>
                            </option> <?php endforeach; ?>
						</select>
						<script type="text/javascript">
                            <?php $select = $controller->getFilterSession()->get($field['index']); ?>
                            $('#<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($select)?$select: '';?>');
                        </script>
               	<?php elseif($field['type'] == 'datetime'):?>
                		
						<span class="hidden"><?php echo isset($field['label'])?$field['label']: '';?></span>
						<select id="<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>" name="<?php echo isset($field['index'])?$field['index']: '';?>" onchange="pzk_list.filter('<?php echo isset($field['type'])?$field['type']: '';?>', '<?php echo isset($field['index'])?$field['index']: '';?>', this.value);">
                			<option value="">Tất cả</option>
                			<?php foreach($field['option'] as $key => $value):?>
                				<option value="<?php echo $key;?>"><?php echo $value;?></option>
                			<?php endforeach;?>
                		</select>
                		<script type="text/javascript">
                            <?php $datetime = $controller->getFilterSession()->get($field['index']); ?>
                            $('#<?php echo isset($field['index'])?$field['index']: '';?>-<?php echo isset($rand)?$rand: '';?>').val('<?php echo isset($datetime)?$datetime: '';?>');
                        </script>
                <?php else :?>
                	<?php 
					$fieldObj = pzk_obj ( 'core.db.grid.edit.' . $field ['type'] );
					foreach ( $field as $key => $val ) {
						$fieldObj->set ( $key, $val );
					}
					$fieldObj->setLayout ( 'admin/grid/index/filter/' . $field ['type'] );
					$value = $controller->getFilterSession ()->get ( $field ['index'] );
					$fieldObj->setValue ( $value );
					$fieldObj->display ();
					?>
				<?php endif;?>
			<?php  endforeach; ?>
		<?php endif; ?>