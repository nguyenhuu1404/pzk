<?php
class PzkAdminSiteController extends PzkGridAdminController {
    public $addFields = 'name, domain, appName, appId, status';
    public $editFields = 'name, domain, appName, appId, status';
    public $table = 'site_site';
	public $selectFields = 'site_site.*, creator.name as creatorName, modifier.name as modifiedName';
    public $filterStatus = true;
	public $logable = true;
	public $logFields = 'name, domain, appName, appId, status';
    public $sortFields = array(
        'id asc' => 'ID tăng',
        'id desc' => 'ID giảm',
        'name asc' => 'Tên tăng',
        'name desc' => 'Tên giảm',
    	'domain asc' => 'Tên miền tăng',
        'domain desc' => 'Tên miền giảm',
		'appName asc' => 'Ứng dụng tăng',
    	'appName desc' => 'Ứng dụng giảm',
    );
	public $joins = array(
		array(
			'table' => '`admin` as `creator`',
			'condition' => 'site_site.creatorId = creator.id',
			'type' => 'left'
		),
		array(
			'table' => '`admin` as `modifier`',
			'condition' => 'site_site.modifiedId = modifier.id',
			'type' => 'left'
		),
	);
    public $searchFields = array('name');
    public $Searchlabels = 'Tên trang web';
    public $listFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên trang'
        ),
		array(
            'index' => 'domain',
            'type' => 'text',
            'label' => 'Tên miền'
        ),
		array(
            'index' => 'appName',
            'type' => 'text',
            'label' => 'Ứng dụng'
        ),
		array(
            'index' => 'appId',
            'type' => 'text',
            'label' => 'ID Ứng dụng'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        ),
		array(
			'index'	=> 'none5',
			'type'	=> 'group',
			'label'	=> '<br />Ngày tạo<br />Ngày sửa',
			'delimiter'	=> '<br />',
			'fields'	=> array(
				array(
					'index' => 'created',
					'type' => 'datetime',
					'label' => 'Ngày tạo',
					'format'	=> 'H:i d/m'
				),
				array(
					'index' => 'modified',
					'type' => 'datetime',
					'label' => 'Ngày sửa',
					'format'	=> 'H:i d/m'
				),
			)
		),
		array(
			'index'	=> 'none5',
			'type'	=> 'group',
			'label'	=> '<br />Ngày bắt đầu<br />Ngày kết thúc',
			'delimiter'	=> '<br />',
			'fields'	=> array(
				array(
					'index' => 'startDate',
					'type' => 'datetime',
					'label' => 'Ngày bắt đầu',
					'format'	=> 'd/m'
				),
				array(
					'index' => 'endDate',
					'type' => 'datetime',
					'label' => 'Ngày kết thúc',
					'format'	=> 'd/m'
				),
			)
		),
    );
	
    public $addLabel = 'Thêm Trang web';
    public $addFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên trang web',
        ),
        array(
            'index' => 'domain',
            'type' => 'text',
            'label' => 'Tên miền'
        ),
		array(
            'index' => 'appName',
            'type' => 'text',
            'label' => 'Ứng dụng'
        ),
		array(
            'index' => 'appId',
            'type' => 'text',
            'label' => 'ID Ứng dụng'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        ),
		
    );
    public $editFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên trang web',
        ),
        array(
            'index' => 'domain',
            'type' => 'text',
            'label' => 'Tên miền'
        ),
		array(
            'index' => 'appName',
            'type' => 'text',
            'label' => 'Ứng dụng'
        ),
		array(
            'index' => 'appId',
            'type' => 'text',
            'label' => 'ID Ứng dụng'
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'Trạng thái'
        )
    );
    public $addValidator = array(
        'rules' => array(
            'name' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'name' => array(
                'required' => 'Tên menu không được để trống',
                'minlength' => 'Tên menu phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên menu chỉ dài tối đa 50 ký tự'
            )

        )
    );
    public $editValidator = array(
        'rules' => array(
            'name' => array(
                'required' => true,
                'minlength' => 2,
                'maxlength' => 50
            )

        ),
        'messages' => array(
            'name' => array(
                'required' => 'Tên menu không được để trống',
                'minlength' => 'Tên menu phải dài 2 ký tự trở lên',
                'maxlength' => 'Tên menu chỉ dài tối đa 50 ký tự'
            )

        )
    );
	
	public $links = array(
		array(
			'name'	=> 'Xuất bản',
			'href'	=> '/admin_site/publish'
		)
	);
	
	public function publishAction() {
		$content = '<core.system id="system" bootstrap="application">
	<core.loader id="loader" />
	<core.request id="request" />';
		$sites = _db()->selectAll()->fromSite_site()->result();
		foreach($sites as $site) {
			$content .= '
	<core.rewrite.host name="'.$site['domain'].'" app="'.$site['appName'].'" softwareId="'.$site['appId'].'" />
	<core.rewrite.host name="'.$site['domain'].':8080" app="'.$site['appName'].'" softwareId="'.$site['appId'].'" />';
		}
		$content.= '
</core.system>';
		file_put_contents(BASE_DIR .'/system/full.php', $content);
		$this->redirect('index');
	}

}
?>