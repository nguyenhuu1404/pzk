<?php
class PzkAdminServicePolicyController extends PzkGridAdminController {
	public $title = 'Giảm giá dịch vụ';
	public $addFields = 'serviceId, discount, note, startDate, endDate,status';
	public $editFields ='serviceId, discount, note, startDate, endDate,status';
	public $table='service_policy';
	public $logable = true;
	public $logFields = 'serviceId, discount, note, startDate, endDate,status';
	public $joins = array(
     
        array(
            'table' => 'service_packages',
            'condition' => 'service_policy.serviceId = service_packages.id',
            'type' =>''
        ),
		array(
			'table' => 'campaign',
			'condition' => 'service_policy.campaignId = campaign.id',
			'type' => 'left'
		),
		array(
			'table' => '`admin` as `creator`',
			'condition' => 'service_policy.creatorId = creator.id',
			'type' => 'left'
		),
		array(
			'table' => '`admin` as `modifier`',
			'condition' => 'service_policy.modifiedId = modifier.id',
			'type' => 'left'
		),
    );
    public $selectFields = 'service_policy.*,service_packages.serviceName as serviceName, service_packages.serviceType as serviceType, campaign.name as campaignName,creator.name as creatorName, modifier.name as modifiedName';
	public $sortFields = array(
		'id asc' => 'ID tăng',
		'id desc' => 'ID giảm',
		'serviceId asc' => 'serviceId tăng',
		'serviceId desc' => 'serviceId giảm',
		'note asc' => 'note tăng',
		'note desc' => 'note giảm',
		'startDate asc' => 'startDate tăng',
		'startDate desc' => 'startDate giảm',
		'endDate asc' => 'endDate tăng',
		'endDate desc' => 'endDate giảm'
	);
	public $searchFields = array('id','serviceId','discount','startDate', 'endDate');
	public $listFieldSettings = array(
		array(
			'index' => 'serviceName',
			'type' => 'text',
			'label' => 'Tên dịch vụ'
		),
		array(
			'index' => 'serviceType',
			'type' => 'text',
			'label' => 'Loại dịch vụ'
		),
		array(
			'index' => 'discount',
			'type' => 'text',
			'label' => 'Giảm giá(tính theo %) '
		),
		
		array(
			'index' => 'note',
			'type' => 'text',
			'label' => 'Ghi chú'
		),
		array(
			'index' => 'startDate',
			'type' => 'datetime',
			'label' => 'Ngày bắt đầu ',
			'format'	=> 'd/m/Y'
		),
		array(
			'index' => 'endDate',
			'type' => 'datetime',
			'label' => 'Ngày kết thúc',
			'format'	=> 'd/m/Y'
		),
		array(
			'index' => 'status',
			'type' => 'workflow',
			'label' => 'Trạng thái',
			'states' => array(
				'0' => 'Không hoạt động',
				'1' => 'Hoạt động',
				'-1' => 'Dừng hoạt động'
			),
			'rules' => array(
				'0' => array('1' => array('action' => 'Kích hoạt')),
				'1' => array(
					'0' => array('action' => 'Khóa'),
					'-1' => array('action' =>  'Tạm dừng')),
				'-1' => array(
					'1' => array('action' => 'Mở lại')
				)
			),
			'bgcolor' => '',
			'color' => ''
		),
		array(
            'index' => 'campaignName',
            'type' => 'text',
            'label' => 'Tên chiến dịch'
        ),
		array(
			'index'	=> 'none4',
			'type'	=> 'group',
			'label'	=> '<br />Người tạo<br />Người sửa',
			'delimiter'	=> '<br />',
			'fields'	=> array(
				array(
					'index' => 'creatorName',
					'type' => 'text',
					'label' => 'Người tạo'
				),
				array(
					'index' => 'modifiedName',
					'type' => 'text',
					'label' => 'Người sửa'
				),
			)
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
	);
	public $addLabel = 'Thêm mới';
	public $addFieldSettings = array(
		
		array(
            'index' => 'serviceId',
            'type' => 'select',
            'label' => 'Gói dịch vụ',
            'table' => 'service_packages',
            'show_value' => 'id',
            'show_name' => 'serviceName',
        ),
		array(
			'index' => 'discount',
			'type' => 'text',
			'label' => 'Giảm giá(tính theo %) '
		),
	
		array(
			'index' => 'note',
			'type' => 'text',
			'label' => 'Ghi chú'
		),
		array(
			'index' => 'startDate',
			'type' => 'date',
			'label' => 'Ngày bắt đầu '
		),
		array(
			'index' => 'endDate',
			'type' => 'date',
			'label' => 'Ngày kết thúc'
		),
		array(
			'index'=>'status',
			'type'=>'status',
			'label'=>'Trạng thái',
			'options'=>array(
				'0'=>'Chưa kích hoạt',
				'1'=>'Kích hoạt'
			)
		)
	);
	public $editFieldSettings = array(
		
		array(
            'index' => 'serviceId',
            'type' => 'select',
            'label' => 'Gói dịch vụ',
            'table' => 'service_packages',
            'show_value' => 'id',
            'show_name' => 'serviceName',
        ),
		array(
			'index' => 'discount',
			'type' => 'text',
			'label' => 'Giảm giá(tính theo %) '
		),
	
		array(
			'index' => 'note',
			'type' => 'text',
			'label' => 'Ghi chú'
		),
		array(
			'index' => 'startDate',
			'type' => 'date',
			'label' => 'Ngày bắt đầu '
		),
		array(
			'index' => 'endDate',
			'type' => 'date',
			'label' => 'Ngày kết thúc'
		),
		array(
			'index'=>'status',
			'type'=>'status',
			'label'=>'Trạng thái',
			'options'=>array(
				'0'=>'Chưa kích hoạt',
				'1'=>'Kích hoạt'
			)
		)
	);
	public $addValidator = array(
		'rules' => array(
			'serviceId' => array(
				'required' => true
			),
			
			'discount' => array(
				'required' => true
				
			),
			'startDate' => array(
				'required' => true
				
			),
			'endDate' => array(
				'required' => true
				
			)

		),
		'messages' => array(
			'serviceId' => array(
				'required' => 'Mã dịch vụ không được để trống'
				
			),
			'discount' => array(
				'required' => 'Giảm giá không được để trống'
				
			),
			'startDate' => array(
				'required' => 'Ngày bắt đầu không được để trống'
				
			),
			'starEnd' => array(
				'required' => 'Ngày kết thúc không được để trống'
				
			)
		)
	);
	public $editValidator = array(
		'rules' => array(
			'serviceId' => array(
				'required' => true
			),
			
			'discount' => array(
				'required' => true
				
			),
			'startDate' => array(
				'required' => true
				
			),
			'endDate' => array(
				'required' => true
				
			)

		),
		'messages' => array(
			'serviceId' => array(
				'required' => 'Mã dịch vụ không được để trống'
				
			),
			'discount' => array(
				'required' => 'Giảm giá không được để trống'
				
			),
			'startDate' => array(
				'required' => 'Ngày bắt đầu không được để trống'
				
			),
			'starEnd' => array(
				'required' => 'Ngày kết thúc không được để trống'
				
			)
		)
	);
    public function editPostAction() {
        $row = $this->getEditData();
       
        if($this->validateEditData($row)) {
        	
            $row['modifiedId']=pzk_session('userId');
            $row['modified']=date("Y-m-d H:i:s");
            $this->edit($row);
            pzk_notifier()->addMessage('Cập nhật thành công');
            $this->redirect('index');          
        
        } else {
            pzk_validator()->setEditingData($row);
            $this->redirect('edit/' . pzk_request('id'));
        }
    }
    public function addPostAction() {
        $row = $this->getAddData();
        if($this->validateAddData($row)) {
           	$row['creatorId']=pzk_session('userId');
            $row['created']=date("Y-m-d H:i:s");
            $this->add($row);
            pzk_notifier()->addMessage('Cập nhật thành công');
            $this->redirect('index');
        
        } else {
            pzk_validator()->setEditingData($row);
            $this->redirect('add');
        }
    }

}