<?php
$controller = $data;
$item = $data->getItem();
$row = $item;
$fieldSettings = $controller->getFieldSettings();
$tabs = $controller->getTabs();
$actions = $data->getActions();
?>
<div class="panel panel-default">
<div class="panel-heading">
    <?php if(@$data->backHref && @$data->backLabel) { ?>
  <a class="btn btn-xs btn-default" href="<?php echo isset($data)?$data->backHref: '';?>"><span class="glyphicon glyphicon-arrow-left"></span></a>
  <?php } ?>
	<b><?php echo $data->getLabel(); ?>
	<?php if(@$data->backHref && @$data->backLabel) { ?>
  <a class="btn btn-xs btn-default pull-right" href="<?php echo isset($data)?$data->backHref: '';?>"><span class="glyphicon glyphicon-remove-sign"></span> <?php echo isset($data)?$data->backLabel: '';?></a>
  <?php } ?>
	</b>
</div>
<div class="panel-body borderadmin">
<form role="form" method="<?php echo isset($data)?$data->method: '';?>" enctype="multipart/form-data"  action="<?php echo isset($data)?$data->action: '';?>">
  <input type="hidden" name="id" value="<?php echo isset($item['id'])?$item['id']: '';?>" />
   <?php if($tabs) { ?>
       <div class="form-group clearfix">
           <ul class="nav nav-tabs" role="tablist">
               <?php
               $i=1;
               foreach($tabs as $tab) { ?>
                   <li role="presentation" <?php if($i == 1) { echo "class='active'"; }?> ><a href="#<?php echo isset($tab['index'])?$tab['index']: '';?>" aria-controls="<?php echo isset($tab['name'])?$tab['name']: '';?>" role="tab" data-toggle="tab"><?php echo isset($tab['name'])?$tab['name']: '';?></a></li>
                   <?php $i++; } ?>

           </ul>

           <div class="tab-content">
               <?php
               $i=1;
               foreach($tabs as $tab) { ?>
                   <div role="tabpanel" class="tab-pane <?php if($i == 1) { echo "active"; }?>" id="<?php echo isset($tab['index'])?$tab['index']: '';?>">
						<?php 
						foreach($tab['fields'] as $field ) { 
							$fieldObj = pzk_obj('core.db.grid.edit.' . $field['type']); 
					
							foreach($field as $key => $val) {
								$fieldObj->set($key, $val);
							}
							$fieldObj->setValue(@$row[$field['index']]); 
							$fieldObj->display();
					   } 
					   ?>
                   </div>
                   <?php $i++; } ?>

           </div>


       </div>
    <?php }else { ?>

  <?php foreach ( $fieldSettings as $field ) : ?>
  
  <?php
			if(pzk_request('hidden_' . $field['index'])) {
				echo '<div style="display: none;">';
			}
		    $fieldObj = pzk_obj('core.db.grid.edit.' . $field['type']); 
    
			foreach($field as $key => $val) {
				$fieldObj->set($key, $val);
			}
			$fieldObj->setValue(@$row[$field['index']]); 
			$fieldObj->display();
			if(pzk_request('hidden_' . $field['index'])) {
				echo '</div>';
			}
	?>
  <?php endforeach; ?>

  <?php } ?>
  <div class="col-xs-12">
  <?php foreach ( $actions as $action ) : ?>
  <button type="submit" name="<?php echo isset($action['name'])?$action['name']: '';?>" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> <?php echo isset($action['label'])?$action['label']: '';?></button>
  <?php endforeach; ?>
  <?php if(@$data->backHref && @$data->backLabel) { ?>
  <a class="btn btn-default" href="<?php echo isset($data)?$data->backHref: '';?>"><span class="glyphicon glyphicon-remove-sign"></span> <?php echo isset($data)?$data->backLabel: '';?></a>
  <?php } ?>
  </div>
</form>
 <script type="text/javascript">
	$(function () {
        setTinymce();
	});
</script>
</div>
</div>