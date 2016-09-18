<?php
class PzkDefaultAdminUserController extends PzkGridAdminController {
	public $title = 'Quản lý học sinh';
	public $table = 'user';
	public $joins = array (
			array (
					'table' => 'areacode',
					'condition' => 'user.areacode = areacode.id',
					'type' => 'left' 
			),
			array (
					'table' => '`admin` as `creator`',
					'condition' => '`user`.creatorId = creator.id',
					'type' => 'left' 
			),
			array (
					'table' => '`admin` as `modifier`',
					'condition' => '`user`.modifiedId = modifier.id',
					'type' => 'left' 
			)
	);
	public $selectFields = '`user`.*, areacode.name as areaname, creator.name as creatorName, modifier.name as modifiedName, paid_id as paid, paid_1_id as test_paid, paid_2_id as test_paid_2';
	public $addFields = 'name, username,password,confirmpassword, email, address, phone, birthday, areacode, school,class, status, registeredAtSoftware, registeredAtSite';
	public $editFields = 'name, username,password,confirmpassword, email, address, phone, birthday,areacode, school,class, status, registeredAtSoftware, registeredAtSite';
	public $exportFields = array (
			'name',
			'email',
			'phone',
			'username',
			'areacode' 
	);
	public $exportTypes = array (
			'pdf',
			'excel',
			'csv' 
	);
	public $sortFields = array (
			'id asc' => 'ID tăng',
			'id desc' => 'ID giảm',
			'name asc' => 'Tên tăng',
			'name desc' => 'Tên giảm',
			'username asc' => 'Username tăng',
			'username desc' => 'Username giảm' 
	);
	public $searchFields = array (
			'`user`.`name`',
			'`user`.areacode',
			'`user`.username',
			'`user`.email',
			'`user`.phone',
			'`user`.address'
	);
	public $filterFields = array (
			
			array (
					'index' => 'areacode',
					'type' => 'select',
					'label' => 'Lọc theo Vùng miền',
					'table' => 'areacode',
					'show_value' => 'id',
					'show_name' => 'name' 
			),
			array (
					'index' => 'status',
					'type' => 'status',
					'option' => array (
							'' => 'Tất cả',
							'0' => ' Chưa kích hoạt',
							'1' => 'Đã kích hoạt' 
					),
					'label' => 'Trạng thái kích hoạt' 
			) ,
			array (
					'index' => 'registeredAtSoftware',
					'type' => 'selectoption',
					'option' => array (
							'' => 'Tất cả',
							'1' => 'Fullook/Song ngữ',
							'2' => 'Thi tài' 
					),
					'label' => 'Đăng ký trên phần mềm' 
			)  ,
			array (
					'index' => 'registeredAtSite',
					'type' => 'selectoption',
					'option' => array (
							'' => 'Tất cả',
							'1' => 'Fullook',
							'2' => 'Fullook Song Ngữ' 
					),
					'label' => 'Đăng ký trên website' 
			) 
	);
	public $menuLinks = array (
			array (
					'name' => 'Người dùng đã thanh toán',
					'href' => '/admin_user/payment' 
			) 
	);
	public $links = array (
			array (
					'name' => 'Báo cáo',
					'href' => '/admin_report_user/index',
					'target' => '_blank' 
			) 
	);
	public $listFieldSettings = array (
			array (
					'index' => 'noneInfo',
					'type' => 'group',
					'label' => 'Info',
					'delimiter' => '<br />',
					'fields' => array (
							array (
									'index' => 'name',
									'type' => 'text',
									'label' => 'Tên',
									'bgcolor' => '',
									'color' => '' 
							),
							array (
									'index' => 'username',
									'type' => 'text',
									'label' => 'Tên đăng nhập',
									'bgcolor' => '',
									'color' => '',
									'link' => '/admin_user/edit/' 
							),
							array (
									'index' => 'email',
									'type' => 'text',
									'label' => 'Thư điện tử',
									'bgcolor' => '' 
							),
							array (
									'index' => 'phone',
									'type' => 'text',
									'label' => 'Số điện thoại',
									'bgcolor' => '',
									'color' => '' 
							) 
					) 
			),
			array (
					'index' => 'noneAddress',
					'type' => 'group',
					'label' => 'Address',
					'delimiter' => '<br />',
					'fields' => array (
							array (
									'index' => 'areaname',
									'type' => 'text',
									'label' => 'Vùng',
									'bgcolor' => '',
									'color' => '' 
							),
							array (
									'index' => 'address',
									'type' => 'text',
									'label' => 'Dia chi',
									'bgcolor' => '',
									'color' => '' 
							),
							array (
									'index' => 'school',
									'type' => 'text',
									'label' => 'Truong',
									'bgcolor' => '',
									'color' => '' 
							),
							array (
									'index' => 'class',
									'type' => 'text',
									'label' => 'Lop',
									'bgcolor' => '',
									'color' => '' 
							) 
					) 
			),
			
			array (
					'index' => 'birthday',
					'type' => 'text',
					'label' => 'Ngày sinh',
					'bgcolor' => '',
					'color' => '' 
			),
			
			array (
					'index' => 'registered',
					'type' => 'datetime',
					'label' => 'Ngày đăng ký',
					'format' => 'H:i:s d/m/Y',
					'bgcolor' => '',
					'color' => '' 
			),
			array (
					'index' => 'registeredAtSoftware',
					'type' => 'text',
					'label' => 'SoftwareId',
					'color' => 'red' 
			),
			array (
					'index' => 'registeredAtSite',
					'type' => 'text',
					'label' => 'SiteId',
					'color' => 'red' 
			),
			array (
					'index' => 'nonePaid',
					'type' => 'group',
					'label' => 'Thanh toán<br />Thanh toán đợt 1<br />Thanh toán đợt 2',
					'delimiter' => '<br />',
					'fields' => array (
							array (
									'index' => 'paid',
									'type' => 'text',
									'label' => 'Mã thanh toán',
									'color' => 'red' 
							),
							array (
									'index' => 'test_paid',
									'type' => 'text',
									'label' => 'Mã thi thử',
									'color' => 'red' 
							),
							array (
									'index' => 'test_paid_2',
									'type' => 'text',
									'label' => 'Mã thi thử đợt 2',
									'color' => 'red' 
							),
					)
			),
			array (
					'index' => 'contactStatus',
					'type' => 'workflow',
					'label' => 'Liên hệ',
					'states' => array (
							'0' => 'Chưa liên hệ',
							'1' => 'Đã liên hệ'
					),
					'rules' => array (
							'0' => array (
									'1' => array (
											'action' => 'Đã liên hệ' ,
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									) 
							),
							'1' => array (
									'0' => array (
											'action' => 'Chưa liên hệ' ,
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									)
							)
					),
					'bgcolor' => '',
					'color' => '' 
			),
			array (
					'index' 	=> 'note',
					'type' 		=> 'text',
					'label' 	=> 'Ghi chú',
					'bgcolor' 	=> '',
					'color' 	=> '' 
			),
			array (
					'index' => 'status',
					'type' => 'workflow',
					'label' => 'Trạng thái',
					'states' => array (
							'0' => 'Không hoạt động',
							'1' => 'Hoạt động',
							'-1' => 'Dừng hoạt động' 
					),
					'rules' => array (
							'0' => array (
									'1' => array (
											'action' => 'Kích hoạt',
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									) 
							),
							'1' => array (
									'0' => array (
											'action' => 'Khóa' ,
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									),
									'-1' => array (
											'action' => 'Tạm dừng' ,
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									) 
							),
							'-1' => array (
									'1' => array (
											'action' => 'Mở lại' ,
											'adminLevel' => 'Accountant, ChiefAccountant, Manager'
									) 
							) 
					),
					'bgcolor' => '',
					'color' => '' 
			),
			array (
					'index' => 'none4',
					'type' => 'group',
					'label' => '<br />Người tạo<br />Người sửa',
					'delimiter' => '<br />',
					'fields' => array (
							array (
									'index' => 'creatorName',
									'type' => 'text',
									'label' => 'Người tạo' 
							),
							array (
									'index' => 'created',
									'type' => 'datetime',
									'label' => 'Ngày tạo',
									'format' => 'H:i d/m' 
							),
							array (
									'index' => 'modifiedName',
									'type' => 'text',
									'label' => 'Người sửa' 
							),
							array (
									'index' => 'modified',
									'type' => 'datetime',
									'label' => 'Ngày sửa',
									'format' => 'H:i d/m' 
							)
					) 
			),
			array (
					'index' => 'nonePayment',
					'type' => 'group',
					'label' => 'Hóa đơn',
					'delimiter' => '<br />',
					'fields' => array (
							array (
									'index' => 'makePayment',
									'type' => 'link',
									'label' => 'Tạo hóa đơn',
									'link' => '/admin_user/makePayment/'
							)
					)
			)
	);
	public $logable = true;
	public $logFields = 'name, username,password, email, address, phone, birthday, areacode, school,class, status';
	public $addLabel = 'Thêm người dùng';
	public $addFieldSettings = array (
			array (
					'index' 	=> 'name',
					'type' 		=> 'text',
					'label' 	=> 'Họ và tên',
					'mdsize'	=> 3
			),
			array (
					'index' 	=> 'username',
					'type' 		=> 'text',
					'label' 	=> 'Tên đăng nhập',
					'mdsize'	=> 3
			),
			array (
					'index' 	=> 'password',
					'type' 		=> 'password',
					'label' 	=> 'Mật khẩu' ,
					'mdsize'	=> 3
			),
			array (
					'index' => 'confirmpassword',
					'type' => 'password',
					'label' => 'Xác nhận mật khẩu' ,
					'mdsize'	=> 3
			),
			array (
					'index' => 'email',
					'type' => 'email',
					'label' => 'Thư điện tử' ,
					'mdsize'	=> 6
			),
			array (
					'index' => 'birthday',
					'type' => 'date',
					'label' => 'Ngày sinh' ,
					'mdsize'	=> 6
			),
			array (
					'index' => 'address',
					'type' => 'text',
					'label' => 'Địa chỉ' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'phone',
					'type' => 'text',
					'label' => 'Số điện thoại' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'areacode',
					'type' => 'select',
					'label' => 'Tỉnh/TP',
					'table' => 'areacode',
					'show_value' => 'id',
					'show_name' => 'name' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'school',
					'type' => 'text',
					'label' => 'Trường' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'class',
					'type' => 'text',
					'label' => 'Lớp',
					'mdsize'	=> 2 
			),
			array (
					'index' => 'status',
					'type' => 'status',
					'label' => 'Trạng thái',
					'mdsize'	=> 2 
			)
	);
	public $editFieldSettings = array (
			array (
					'index' 	=> 'name',
					'type' 		=> 'text',
					'label' 	=> 'Họ và tên',
					'mdsize'	=> 3
			),
			array (
					'index' 	=> 'username',
					'type' 		=> 'text',
					'label' 	=> 'Tên đăng nhập',
					'mdsize'	=> 3
			),
			array (
					'index' 	=> 'password',
					'type' 		=> 'password',
					'label' 	=> 'Mật khẩu' ,
					'mdsize'	=> 3
			),
			array (
					'index' => 'confirmpassword',
					'type' => 'password',
					'label' => 'Xác nhận mật khẩu' ,
					'mdsize'	=> 3
			),
			array (
					'index' => 'email',
					'type' => 'email',
					'label' => 'Thư điện tử' ,
					'mdsize'	=> 6
			),
			array (
					'index' => 'birthday',
					'type' => 'date',
					'label' => 'Ngày sinh' ,
					'mdsize'	=> 6
			),
			array (
					'index' => 'address',
					'type' => 'text',
					'label' => 'Địa chỉ' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'phone',
					'type' => 'text',
					'label' => 'Số điện thoại' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'areacode',
					'type' => 'select',
					'label' => 'Tỉnh/TP',
					'table' => 'areacode',
					'show_value' => 'id',
					'show_name' => 'name' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'school',
					'type' => 'text',
					'label' => 'Trường' ,
					'mdsize'	=> 2
			),
			array (
					'index' => 'class',
					'type' => 'text',
					'label' => 'Lớp',
					'mdsize'	=> 2 
			),
			array (
					'index' => 'status',
					'type' => 'status',
					'label' => 'Trạng thái',
					'mdsize'	=> 2 
			)
	);
	public $addValidator = array (
			'rules' => array (
					'name' => array (
							'required' => true,
							'minlength' => 2,
							'maxlength' => 50 
					),
					'username' => array (
							'required' => true,
							'minlength' => 5,
							'maxlength' => 50 
					),
					'password' => array (
							'required' => true,
							'minlength' => 5,
							'maxlength' => 50 
					),
					'confirmpassword' => array (
							'required' => true,
							'minlength' => 5,
							'maxlength' => 50 
					),
					'email' => array (
							'required' => true,
							'email' => true,
							'maxlength' => 50 
					) 
			),
			'messages' => array (
					'name' => array (
							'required' => 'Tên không được để trống',
							'minlength' => 'Tên phải dài 2 ký tự trở lên',
							'maxlength' => 'Tên chỉ dài tối đa 50 ký tự' 
					),
					'username' => array (
							'required' => 'Tên đăng nhập không được để trống',
							'minlength' => 'Tên đăng nhập phải dài 5 ký tự trở lên',
							'maxlength' => 'Tên đăng nhập chỉ dài tối đa 50 ký tự' 
					),
					'password' => array (
							'required' => 'Mật khẩu không được để trống',
							'minlength' => 'Mật khẩu phải dài 5 ký tự trở lên',
							'maxlength' => 'Mật khẩu chỉ dài tối đa 50 ký tự' 
					),
					'confirmpassword' => array (
							'required' => 'Nhập lại mật khẩu' 
					)
					,
					'email' => array (
							'required' => 'Email không được để trống',
							'email' => 'Email phải đúng định dạng',
							'maxlength' => 'Độ dài tối đa của email là 50 ký tự' 
					) 
			) 
	);
	public $editValidator = array (
			'rules' => array (
					'name' => array (
							'required' => true,
							'minlength' => 2,
							'maxlength' => 50 
					),
					'username' => array (
							'required' => true,
							'minlength' => 5,
							'maxlength' => 50 
					),
					
					'email' => array (
							'required' => true,
							'email' => true,
							'maxlength' => 50 
					) 
			),
			'messages' => array (
					'name' => array (
							'required' => 'Tên không được để trống',
							'minlength' => 'Tên phải dài 2 ký tự trở lên',
							'maxlength' => 'Tên chỉ dài tối đa 50 ký tự' 
					),
					'username' => array (
							'required' => 'Tên đăng nhập không được để trống',
							'minlength' => 'Tên đăng nhập phải dài 5 ký tự trở lên',
							'maxlength' => 'Tên đăng nhập chỉ dài tối đa 50 ký tự' 
					),
					
					'email' => array (
							'required' => 'Email không được để trống',
							'email' => 'Email phải đúng định dạng',
							'maxlength' => 'Độ dài tối đa của email là 50 ký tự' 
					) 
			) 
	);
	public $passwordValidator = array (
			'rules' => array (
					'password' => array (
							'minlength' => 6,
							'equalTo' => '' 
					) 
			),
			'messages' => array (
					'password' => array (
							'minlength' => 'Mật khẩu dài tối thiểu 6 ký tự',
							'equalTo' => 'Mật khẩu nhập lại không khớp' 
					) 
			) 
	);
	public function editPostAction() {
		$row = $this->getEditData ();
		$row ['registeredAtSoftware'] = pzk_request('SoftwareId');
		$row ['registeredAtSite'] = pzk_request('SiteId');
		if ($this->validateEditData ( $row )) {
			$password = trim ( pzk_request ( 'password' ) );
			$confirmpassword = trim ( pzk_request ( 'confirmpassword' ) );
			// $this->passwordValidator['rules']['password']['equalTo'] = $confirmpassword;
			if ($password) {
				$this->passwordValidator ['rules'] ['password'] ['equalTo'] = $confirmpassword;
				$passwordValidateResult = $this->validate ( array (
						'password' => $password 
				), $this->passwordValidator );
				if ($passwordValidateResult) {
					$row ['password'] = md5 ( $password );
					
					$this->edit ( $row );
					pzk_notifier ()->addMessage ( 'Cập nhật thành công' );
					$this->redirect ( 'index' );
				} else {
					pzk_validator ()->setEditingData ( $row );
					$this->redirect ( 'edit/' . pzk_request ( 'id' ) );
				}
			} else {
				// $this->edit($row);
				$user = _db ()->getEntity ( 'user.account.user' );
				$user->loadWhere ( array (
						'id',
						pzk_request ( 'id' ) 
				) );
				if ($user->getId ()) {
					$user->update ( array (
							'name' 			=> $row ['name'],
							'username' 		=> $row ['username'],
							'birthday' 		=> $row ['birthday'],
							'email' 		=> $row ['email'],
							'address' 				=> $row ['address'],
							'phone' 				=> $row ['phone'],
							'school' 				=> $row ['school'],
							'class' 				=> $row ['class'],
							'areacode' 				=> $row ['areacode'],
							'status' 				=> $row ['status'],
							'registeredAtSoftware' 	=>  $row ['registeredAtSoftware'],
							'registeredAtSite' 		=> $row ['registeredAtSite']
					) );
					pzk_notifier ()->addMessage ( 'Cập nhật thành công' );
					$this->redirect ( 'index' );
				}
			}
		} else {
			pzk_validator ()->setEditingData ( $row );
			$this->redirect ( 'edit/' . pzk_request ( 'id' ) );
		}
	}
	public function addPostAction() {
		$row = $this->getAddData ();
		if ($this->validateAddData ( $row )) {
			$password 			= trim ( pzk_request ( 'password' ) );
			$confirmpassword 	= trim ( pzk_request ( 'confirmpassword' ) );
			$this->passwordValidator ['rules'] ['password'] ['equalTo'] = $confirmpassword;
			$passwordValidateResult = $this->validate ( array (
					'password' => $password 
			), $this->passwordValidator );
			if ($passwordValidateResult) {
				$row ['password'] = md5 ( $password );
				$row ['registeredAtSoftware'] = pzk_request('SoftwareId');
				$row ['registeredAtSite'] = pzk_request('SiteId');
				$this->add ( $row );
				pzk_notifier ()->addMessage ( 'Cập nhật thành công' );
				$this->redirect ( 'index' );
			} else {
				pzk_validator ()->setEditingData ( $row );
				$this->redirect ( 'add' );
			}
		} else {
			pzk_validator ()->setEditingData ( $row );
			$this->redirect ( 'add' );
		}
	}
	public function paymentAction() {
		$this->initPage ()
				->append ( 'admin/user/payment' )
				->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/menu', 'right' );
		$this->fireEvent ( 'index.after', $this );
		$this->display ();
	}
	public function searchPostAction() {
		pzk_session ( $this->table . 'Keyword', pzk_request ( 'keyword' ) );
		$this->redirect ( 'payment' );
	}
	public function makePaymentAction($id) {
		$user 			= 	_db()->selectAll()->fromUser()->whereId($id)->result_one();
		$username 		= 	$user['username'];	
		$date			=	date_create(date("Y-m-d"));
		$expireddate 	= 	date_add($date,date_interval_create_from_date_string("365 days"));
		$expireddate 	=	date_format($date,"Y-m-d");
		$service 		= 	_db()->selectAll()->from('service_packages')->whereServiceType('full')->result_one();
		$data 			= 	array(
				'username'		=> $username,
				'typepayment'	=> 'bank',
				'paymentstatus'	=> '1',
				'status'		=> '2',
				'amount'		=> '',
				'datepayment'	=> date('Y-m-d'),
				'expireddate'	=> $expireddate,
				'serviceId'		=> $service ? $service['id']: false
		);
		pzk_validator()->setEditingData($data);
		$this->redirect('admin_payment_historypayment/add');
	}
	
	
	
	
}