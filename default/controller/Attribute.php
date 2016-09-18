<?php
require_once dirname(__FILE__) . '/Base.php';
class PzkAttributeController extends PzkBaseController {
	public function indexAction() {
		$this->viewGrid('attribute/attribute');
	}
	public function groupAction() {
		$this->viewGrid('attribute/group');
	}
	public function groupattributeAction() {
		$this->viewGrid('attribute/group_attribute');
	}
	public function setAction() {
		$this->viewGrid('attribute/set');
	}
	public function typeAction() {
		$this->viewGrid('attribute/type');
	}
	public function showAction() { // set id
	}
	public function testSetAction() {
		$request = pzk_element('request');
		if($request->host == 'phongthuy.vn' || $request->host == 'www.phongthuy.vn') {
			$this->masterStructure = 'master-admin';
			$this->masterPosition = 'left';
		}
		$id = pzk_element('request')->get('id', 1);
		$set = _db()->getEntity('attribute.set')->load($id);
		
		$gridbuilder = pzk_parse('<ide.builder.grid />');
		$gridbuilder->set = $set;
		
		$gridCode = $gridbuilder->getContent();
		$this->view($gridCode);
	}
	public function testAttributeAction() {
		$id = pzk_element('request')->get('id', 1);
		$attribute = _db()->getEntity('attribute.attribute')->load($id);
		
		$attributebuilder = pzk_parse('<ide.builder.attribute />');
		$attributebuilder->attribute = $attribute;
		$code = $attributebuilder->getContent();
		$this->view($code);
	}
	public function testTagAction() {
		$tag = array(
			'tagName' => 'html.head',
			'attributes' => array(
			
			)
		);
		$tagbuilder = pzk_parse('<ide.builder.tag />');
		$tagbuilder->tag = $tag;
		pre($tagbuilder->getContent());
	}
	
	public function testQueryAction() {
		$id = pzk_element('request')->get('id', 1);
		$query = _db()->getEntity('query.query')->load($id);
		echo $query->getSQL();
		die();
		$querybuilder = pzk_parse('<ide.builder.query />');
		$querybuilder->query = $query;
		$this->view($querybuilder);
	}
	public function testTypeAction() {
		/*
		$set = _db()->getEntity('attribute.set')->load(3);
		$type = $set->getType();
		var_dump($type);
		$relations = $type->getRelations();
		var_dump($relations);
		foreach($relations as $rel) {
			var_dump($rel->getRelatedType());
			var_dump($rel->getRelationType());
			var_dump($rel->getAttribute());
		}*/
		$set = _db()->getEntity('attribute.set')->load(3);
		$set->children('var_dump');
	}
	
	public function testPermissionAction() {
		$user = _db()->getEntity('profile.profile')->load(3);
		var_dump($user);
		if($user->canDo('student', 'view')) {
			echo 'Can View Student<br />';
		}
		if($user->canDo('student', 'delete')) {
			echo 'Can Delete Student<br />';
		} else {
			echo 'Can Not Delete Student<br />';
		}
	}
}