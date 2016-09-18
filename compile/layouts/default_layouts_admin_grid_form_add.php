<?php
$item = $data->getItem();
$form = $data->getFormObject();
$form->setLabel($data->getLabel());
$form->setFieldSettings($data->getFieldSettings());
$form->setActions($data->getActions());
$form->setAction('/admin_' . $data->getModule(). '/addPost');
$form->setBackHref(pzk_or(pzk_request()->getBackHref(), '/admin_' . $data->getModule(). '/index'));
$form->setBackLabel('Cancel');
if(pzk_request()->getBackHref()) {
	$form->setAction('/admin_' . $data->getModule(). '/addPost?backHref='. urlencode(pzk_request()->getBackHref()));
}
$form->display();
?>