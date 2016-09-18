<?php
class PzkDefaultAdminDocumentController extends PzkGridAdminController {
	public $title 		= 'Quản lý tài liệu';
	public $table 		= 'document';
	public function getJoins() {
		return PzkJoinConstant::gets('category, creator, modifier', 'document');
	}

	public $selectFields = 'document.*, categories.name as categoryName, creator.name as creatorName, modifier.name as modifiedName';
	public function getLinks() {
		return array(
				array(
						'name'	=> 	'Tạo Alias',
						'href'	=> 	'/admin_document/alias'
				),
				array(
					'name'	=> 	'Thêm Nhanh Tài liệu',
					'href'	=> 	'/admin_document/add?status=1&type=document&classes=,5,&hidden_ordering=1&hidden_global=1&hidden_campaignId=1&hidden_sharedSoftwares=1&hidden_startDate=1&hidden_endDate=1&hidden_status=1&hidden_type=1&hidden_alias=1&hidden_meta_keywords=1&hidden_meta_description=1&hidden_brief=1&hidden_img=1&hidden_file=1&hidden_classes=1'
				),
				array(
					'name'	=> 	'Thêm Nhanh Từ vựng',
					'href'	=> 	'/admin_document/add?status=1&type=vocabulary&classes=,5,&hidden_ordering=1&hidden_global=1&hidden_campaignId=1&hidden_sharedSoftwares=1&hidden_startDate=1&hidden_endDate=1&hidden_status=1&hidden_type=1&hidden_alias=1&hidden_meta_keywords=1&hidden_meta_description=1&hidden_brief=1&hidden_img=1&hidden_file=1&hidden_classes=1'
				),
		);
	}
	public function getListFieldSettings() { 
		return array(
			PzkListConstant::get('img', 'document'),
			
			PzkListConstant::group('<br />Tiêu đề<br />Bí danh', 'title, alias', 'document'),
			PzkListConstant::group('<br />Từ khóa<br />Mô tả', 'meta_keywords, meta_description', 'document'),
			PzkListConstant::get('categoryName', 'document'),
			PzkListConstant::get('campaignName', 'document'),
			PzkListConstant::group('<br />Xem<br />Thích<br />Bình luận', 'views, likes, comments', 'document'),
			PzkListConstant::group('<br />Người tạo<br />Người sửa', 'creatorName, modifiedName', 'document'),
			PzkListConstant::group('<br />Ngày tạo<br />Ngày sửa', 'created, modified', 'document'),
			PzkListConstant::get('trial', 'document'),
			PzkListConstant::get('ordering', 'document'),
			PzkListConstant::get('classes', 'document'),
			/*PzkListConstant::get('file', 'document'),*/
			PzkListConstant::get('status', 'document'),
		);
	}
	
	public $searchLabel = 'Tìm kiếm';
	public $searchFields = array('`document`.title', '`document`.alias');
	
	public function getFilterFields () { 
		return PzkFilterConstant::gets('subjectCategory', 'document');
	}
	public function getSortFields() {
		return PzkSortConstant::gets('id, title, categoryId, ordering', 'document');
	}
	
	public $quickMode = false;
	public function getQuickFieldSettings(){
		return PzkListConstant::gets('title', 'document');
	}
	
	public $logable = true;
	public $logFields = 'title, type, categoryId, img, content, brief, trial, alias, file, ordering, classes';
	
	public $addLabel = 'Thêm tài liệu';
	public $addFields = 'title, type, categoryId, img, content, brief, trial, alias, file, ordering, classes, categoryIds,
				meta_keywords, meta_description,  software, global, sharedSoftwares';
	public function getAddFieldSettings() { 
		return PzkEditConstant::gets('title[mdsize=3], alias[mdsize=3], categoryId[mdsize=3],  file[mdsize=3],categoryIds[mdsize=12], img[mdsize=3], trial[mdsize=3], classes[mdsize=3], brief[mdsize=3], typeOfDocument[mdsize=3], content,  ordering[mdsize=2], meta_keywords[mdsize=5], meta_description[mdsize=5]','document');
    }
	
	public $editFields = 'title, type, categoryId, img, content, brief, trial, alias, file, ordering, classes, categoryIds,
				meta_keywords, meta_description,  software, global, sharedSoftwares';
	public function getEditFieldSettings() { 
		return PzkEditConstant::gets('title[mdsize=3], alias[mdsize=3], categoryId[mdsize=3],  file[mdsize=3],categoryIds[mdsize=12], img[mdsize=3], trial[mdsize=3], classes[mdsize=3], brief[mdsize=3], typeOfDocument[mdsize=3], content,  ordering[mdsize=2], meta_keywords[mdsize=5], meta_description[mdsize=5]','document');
    }
	
	public $detailFields = 'document.*, categories.name as categoryName, creator.name as creatorName, modifier.name as modifiedName';
	public function getViewFieldSettings() { 
		return PzkListConstant::gets('title, alias, meta_keywords, meta_description, categoryName,
			campaignName, views, likes, comments, creatorName, modifiedName, created, modified, 
			 statusText, orderingText, briefText', 'document');
	}
	
	public function getChildrenGridSettings() { 
		return array(
			array(
				'index'	=> 'comments',
				'title'	=> 'Bình luận',
				'label'	=> 'Bình luận',
				'table'	=> 'document_comment',
				'parentField'	=> 'documentId',
				'addLabel'	=> 'Thêm bình luận',
				'quickMode'	=> false,
				'module'	=> 'document_comment',
				'listFieldSettings'	=>  PzkListConstant::gets('comment, likes, ip, created', 'document_comment'),
				'sortFields' => PzkSortConstant::gets('id, created, likes', 'document_comment')
			),
			array(
				'index'	=> 'visitor',
				'title'	=> 'Người ghé thăm',
				'label'	=> 'Người ghé thăm',
				'table'	=> 'document_visitor',
				'addLabel'	=> 'Thêm người ghé thăm',
				'quickMode'	=> false,
				'module'	=> 'visitor',
				'parentField'	=> 'documentId',
				'listFieldSettings'	=> PzkListConstant::gets('ip, visited', 'document_visitor'),
				'sortFields' => PzkSortConstant::gets('id, visited', 'document_visitor')
			)
		);
	}
	
	public function getParentDetailSettings() { 
		return array(
			PzkParentConstant::get('creator', 'document'),
			PzkParentConstant::get('modifier', 'document'),
			PzkParentConstant::get('category', 'document', PzkListConstant::gets('nameOfCategory, alias, router, statusText, displayText', 'category'))
		);
	}
}
	
?>