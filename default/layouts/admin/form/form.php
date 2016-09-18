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
    {? if(@$data->backHref && @$data->backLabel) { ?}
  <a class="btn btn-xs btn-default" href="{data.backHref}"><span class="glyphicon glyphicon-arrow-left"></span></a>
  {? } ?}
	<b><?php echo $data->getLabel(); ?>
	{? if(@$data->backHref && @$data->backLabel) { ?}
  <a class="btn btn-xs btn-default pull-right" href="{data.backHref}"><span class="glyphicon glyphicon-remove-sign"></span> {data.backLabel}</a>
  {? } ?}
	</b>
</div>
<div class="panel-body borderadmin">
<form role="form" method="{data.method}" enctype="multipart/form-data"  action="{data.action}">
  <input type="hidden" name="id" value="{item[id]}" />
   <?php if($tabs) { ?>
       <div class="form-group clearfix">
           <ul class="nav nav-tabs" role="tablist">
               <?php
               $i=1;
               foreach($tabs as $tab) { ?>
                   <li role="presentation" <?php if($i == 1) { echo "class='active'"; }?> ><a href="#{tab[index]}" aria-controls="{tab[name]}" role="tab" data-toggle="tab">{tab[name]}</a></li>
                   <?php $i++; } ?>

           </ul>

           <div class="tab-content">
               <?php
               $i=1;
               foreach($tabs as $tab) { ?>
                   <div role="tabpanel" class="tab-pane <?php if($i == 1) { echo "active"; }?>" id="{tab[index]}">
						{? 
						foreach($tab['fields'] as $field ) { 
							$fieldObj = pzk_obj('core.db.grid.edit.' . $field['type']); 
					
							foreach($field as $key => $val) {
								$fieldObj->set($key, $val);
							}
							$fieldObj->setValue(@$row[$field['index']]); 
							$fieldObj->display();
					   } 
					   ?}
                   </div>
                   <?php $i++; } ?>

           </div>


       </div>
    <?php }else { ?>

  {each $fieldSettings as $field}
  
  {?
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
	?}
  {/each}

  <?php } ?>
  <div class="col-xs-12">
  {each $actions as $action}
  <button type="submit" name="{action[name]}" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> {action[label]}</button>
  {/each}
  {? if(@$data->backHref && @$data->backLabel) { ?}
  <a class="btn btn-default" href="{data.backHref}"><span class="glyphicon glyphicon-remove-sign"></span> {data.backLabel}</a>
  {? } ?}
  </div>
</form>
 <script type="text/javascript">
	$(function () {
        setTinymce();
	});
</script>
</div>
</div>