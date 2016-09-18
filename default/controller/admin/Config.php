<?php
/**
 *
 * @author: Huunv
 * date: 21/4
 */
class PzkAdminConfigController extends PzkConfigAdminController {
	public $menuLinks = array (
			array (
					'name' => 'Trang web',
					'href' => '/admin_config/edit?config=site' 
			),
			array (
					'name' => 'Database',
					'href' => '/admin_config/edit?config=database' 
			),
			array (
					'name' => 'Email',
					'href' => '/admin_config/edit?config=email' 
			),
			array (
					'name' => 'Ngân Lượng',
					'href' => '/admin_config/edit?config=nganluong' 
			),
			array (
					'name' => 'Nộp tiền tại văn phòng',
					'href' => '/admin_config/edit?config=office' 
			),
			array (
					'name' => 'Chuyển Khoản',
					'href' => '/admin_config/edit?config=bankTransfer' 
			),
			array (
					'name' => 'Hỗ trợ khách hàng',
					'href' => '/admin_config/edit?config=support' 
			),
			array (
					'name' => 'Thống kê truy cập',
					'href' => '/admin_config/edit?config=stat' 
			),
			array (
					'name' => 'Kích hoạt đăng ký',
					'href' => '/admin_config/edit?config=registerActive' 
			),
			array (
					'name' => 'Xóa cache',
					'href' => '/admin_config/deletecache' 
			),
			array (
					'name' => 'Backup ảnh',
					'href' => '/admin_config/backupImage' 
			),
			array (
					'name' => 'Cache',
					'href' => '/admin_config/edit?config=cache' 
			),
			array (
					'name' => 'Facebook Login',
					'href' => '/admin_config/edit?config=loginFb' 
			),
			array (
					'name' => 'Google Login',
					'href' => '/admin_config/edit?config=loginG' 
			) 
	);
	public $siteFields = array (
			'site_name',
			'site_slogan',
			'site_brief',
			'site_logo',
			'site_url',
			'site_keywords',
			'site_description' 
	);
	public $siteFieldSettings = array (
			array (
					'index' 		=> 'site_name',
					'type' 			=> EDIT_TYPE_TEXT,
					'label' 		=> 'Tên trang web' 
			),
			array (
					'index' 		=> 'site_slogan',
					'type' 			=> EDIT_TYPE_TEXT,
					'label' 		=> 'Khẩu hiệu(slogan)' 
			),
			array (
					'index' 		=> 'site_brief',
					'type' 			=> EDIT_TYPE_TEXT_AREA,
					'label' 		=> 'Mô tả' 
			),
			array (
					'index' 		=> 'site_logo',
					'type' 			=> EDIT_TYPE_FILE_MANAGER,
					'uploadtype'	=> EDIT_TYPE_UPLOAD_TYPE_IMAGE,
					'label' 		=> 'Logo' 
			),
			array (
					'index' 		=> 'site_url',
					'type' 			=> EDIT_TYPE_TEXT,
					'label' 		=> 'Đường dẫn'
			),
			array (
					'index' 		=> 'site_keywords',
					'type' 			=> EDIT_TYPE_TEXT_AREA,
					'label' 		=> 'Từ khóa SEO'
			),
			array (
					'index' 		=> 'site_description',
					'type' 			=> EDIT_TYPE_TEXT_AREA,
					'label' 		=> 'Mô tả SEO'
			),
	);
	public $databaseFields = array (
			'db_host',
			'db_user',
			'db_password',
			'db_database' 
	);
	public $databaseFieldSettings = array (
			array (
					'index' => 'db_host',
					'type' => 'text',
					'label' => 'Tên host' 
			),
			array (
					'index' => 'db_user',
					'type' => 'text',
					'label' => 'Tên user' 
			),
			array (
					'index' => 'db_password',
					'type' => 'password',
					'label' => 'Password' 
			),
			array (
					'index' => 'db_database',
					'type' => 'text',
					'label' => 'Tên database' 
			) 
	);
	public $emailFields = array (
			'email_host',
			'email_user',
			'email_password',
			'email_port' 
	);
	public $emailFieldSettings = array (
			array (
					'index' => 'email_host',
					'type' => 'text',
					'label' => 'Tên host' 
			),
			array (
					'index' => 'email_user',
					'type' => 'text',
					'label' => 'Tên user' 
			),
			array (
					'index' => 'email_password',
					'type' => 'password',
					'label' => 'Password' 
			),
			array (
					'index' => 'email_port',
					'type' => 'text',
					'label' => 'Port' 
			) 
	);
	public $nganluongFields = array (
			'nganluong_merchant' 
	);
	public $nganluongFieldSettings = array (
			array (
					'index' => 'nganluong_merchant',
					'type' => 'text',
					'label' => 'Merchant' 
			) 
	);
	public $bankTransferFields = array (
			'bank_number1',
			'bank_user1',
			'bank_name1',
			'bank_place1',
			'bank_content1',
			'bank_number2',
			'bank_user2',
			'bank_name2',
			'bank_place2',
			'bank_content2',
			'bank_number3',
			'bank_user3',
			'bank_name3',
			'bank_place3',
			'bank_content3',
			'bank_number4',
			'bank_user4',
			'bank_name4',
			'bank_place4',
			'bank_content4',
			'bank_number5',
			'bank_user5',
			'bank_name5',
			'bank_place5',
			'bank_content5',
			'bank_number6',
			'bank_user6',
			'bank_name6',
			'bank_place6',
			'bank_content6',
			'note1',
			'note2',
			'note3' 
	);
	public $bankTransferFieldSettings = array (
			
			array (
					'index' => 'bank_number1',
					'type' => 'text',
					'label' => 'Số tài khoản 1' 
			),
			array (
					'index' => 'bank_user1',
					'type' => 'text',
					'label' => 'Chủ tài khoản 1' 
			),
			array (
					'index' => 'bank_name1',
					'type' => 'text',
					'label' => 'Ngân hàng 1' 
			),
			array (
					'index' => 'bank_place1',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content1',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'bank_number2',
					'type' => 'text',
					'label' => 'Số tài khoản 2' 
			),
			array (
					'index' => 'bank_user2',
					'type' => 'text',
					'label' => 'Chủ tài khoản 2' 
			),
			array (
					'index' => 'bank_name2',
					'type' => 'text',
					'label' => 'Ngân hàng 2' 
			),
			array (
					'index' => 'bank_place2',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content2',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'bank_number3',
					'type' => 'text',
					'label' => 'Số tài khoản 3' 
			),
			array (
					'index' => 'bank_user3',
					'type' => 'text',
					'label' => 'Chủ tài khoản 3' 
			),
			array (
					'index' => 'bank_name3',
					'type' => 'text',
					'label' => 'Ngân hàng 3' 
			),
			array (
					'index' => 'bank_place3',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content3',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'bank_number4',
					'type' => 'text',
					'label' => 'Số tài khoản 4' 
			),
			array (
					'index' => 'bank_user4',
					'type' => 'text',
					'label' => 'Chủ tài khoản 4' 
			),
			array (
					'index' => 'bank_name4',
					'type' => 'text',
					'label' => 'Ngân hàng 4' 
			),
			array (
					'index' => 'bank_place4',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content4',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'bank_number5',
					'type' => 'text',
					'label' => 'Số tài khoản 5' 
			),
			array (
					'index' => 'bank_user5',
					'type' => 'text',
					'label' => 'Chủ tài khoản 5' 
			),
			array (
					'index' => 'bank_name5',
					'type' => 'text',
					'label' => 'Ngân hàng 5' 
			),
			array (
					'index' => 'bank_place5',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content5',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'bank_number6',
					'type' => 'text',
					'label' => 'Số tài khoản 6' 
			),
			array (
					'index' => 'bank_user6',
					'type' => 'text',
					'label' => 'Chủ tài khoản 6' 
			),
			array (
					'index' => 'bank_name6',
					'type' => 'text',
					'label' => 'Ngân hàng 6' 
			),
			array (
					'index' => 'bank_place6',
					'type' => 'text',
					'label' => 'Chi nhánh' 
			),
			array (
					'index' => 'bank_content6',
					'type' => 'text',
					'label' => 'Nội dung' 
			),
			array (
					'index' => 'note1',
					'type' => 'text',
					'label' => 'Ghi chú chuyển tiền qua máy ATM' 
			),
			array (
					'index' => 'note2',
					'type' => 'text',
					'label' => 'Ghi chú giữ lại biên nhận chuyển khoản' 
			),
			array (
					'index' => 'note3',
					'type' => 'text',
					'label' => 'Ghi chú kiểm tra giao dịch' 
			) 
	);
	public $officeFields = array (
			'name_office',
			'address_office',
			'phone_office',
			'note_office' 
	);
	public $officeFieldSettings = array (
			array (
					'index' => 'name_office',
					'type' => 'text',
					'label' => 'Tên văn phòng' 
			),
			array (
					'index' => 'address_office',
					'type' => 'text',
					'label' => 'Địa chỉ' 
			),
			array (
					'index' => 'phone_office',
					'type' => 'text',
					'label' => 'Điện thoại' 
			),
			array (
					'index' => 'note_office',
					'type' => 'text',
					'label' => 'Ghi chú' 
			) 
	);
	public $supportFields = array (
			'hotline',
			'email',
			'yahoo',
			'skype',
			'vn_hotline',
			'vn_email',
			'vn_yahoo',
			'vn_skype',
			'support_en_link',
			'support_vn_link' 
	);
	public $supportFieldSettings = array (
			array (
					'index' => 'support_en_link',
					'type' => 'text',
					'label' => 'Đường dẫn phần mềm tiếng Anh' 
			),
			array (
					'index' => 'hotline',
					'type' => 'text',
					'label' => 'Số hotline (hỗ trợ phần mềm tiếng Anh)' 
			),
			array (
					'index' => 'email',
					'type' => 'text',
					'label' => 'Email hỗ trợ (hỗ trợ phần mềm tiếng Anh)' 
			),
			array (
					'index' => 'yahoo',
					'type' => 'text',
					'label' => 'Yahoo hỗ trợ (hỗ trợ phần mềm tiếng Anh)' 
			),
			array (
					'index' => 'skype',
					'type' => 'text',
					'label' => 'Skype hỗ trợ (hỗ trợ phần mềm tiếng Anh)' 
			),
			array (
					'index' => 'support_vn_link',
					'type' => 'text',
					'label' => 'Đường dẫn phần mềm tiếng Việt' 
			),
			array (
					'index' => 'vn_hotline',
					'type' => 'text',
					'label' => 'Số hotline (hỗ trợ phần mềm tiếng Việt)' 
			),
			array (
					'index' => 'vn_email',
					'type' => 'text',
					'label' => 'Email hỗ trợ (hỗ trợ phần mềm tiếng Việt)' 
			),
			array (
					'index' => 'vn_yahoo',
					'type' => 'text',
					'label' => 'Yahoo hỗ trợ (hỗ trợ phần mềm tiếng Việt)' 
			),
			array (
					'index' => 'vn_skype',
					'type' => 'text',
					'label' => 'Skype hỗ trợ (hỗ trợ phần mềm tiếng Việt)' 
			) 
	);
	public $statFields = array (
			'stat_show_member',
			'stat_show_today',
			'stat_show_yesterday',
			'stat_show_month',
			'stat_show_lastmonth',
			'stat_show_birthday',
			'stat_show_online',
			'stat_show_total' 
	);
	public $statFieldSettings = array (
			array (
					'index' => 'stat_show_member',
					'type' => 'status',
					'label' => 'Hiển thị số thành viên' 
			),
			array (
					'index' => 'stat_show_today',
					'type' => 'status',
					'label' => 'Hiển thị số truy cập trong ngày' 
			),
			array (
					'index' => 'stat_show_yesterday',
					'type' => 'status',
					'label' => 'Hiển thị số truy cập hôm trước' 
			),
			array (
					'index' => 'stat_show_month',
					'type' => 'status',
					'label' => 'Hiển thị số truy cập trong tháng' 
			),
			array (
					'index' => 'stat_show_lastmonth',
					'type' => 'status',
					'label' => 'Hiển thị số truy cập tháng trước' 
			),
			array (
					'index' => 'stat_show_online',
					'type' => 'status',
					'label' => 'Hiển thị số người online' 
			),
			array (
					'index' => 'stat_show_total',
					'type' => 'status',
					'label' => 'Hiển thị tổng cộng' 
			) 
	);
	public $registerActiveFields = array (
			'register_active' 
	);
	public $registerActiveFieldSettings = array (
			array (
					'index' => 'register_active',
					'type' => 'status',
					'label' => 'Kích hoạt đăng ký' 
			) 
	);
	// config time cache
	public $cacheFields = array (
			'time_cache_web',
			'time_cache_session' 
	);
	public $cacheFieldSettings = array (
			array (
					'index' => 'time_cache_web',
					'type' => 'text',
					'label' => 'Thời gian cache' 
			),
			array (
					'index' => 'time_cache_session',
					'type' => 'text',
					'label' => 'Thời gian cache session' 
			) 
	);
	public function deletecacheAction() {
		$this->initPage ()->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/index' )->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/menu', 'right' );
		$cachefiles = glob ( 'cache/*.txt*' );
		foreach ( $cachefiles as $file ) {
			unlink ( 'cache/' . basename ( $file ) );
		}
		$defaultCacher = CACHE_DEFAULT_CACHER;
		$defaultCacher()->clear();
		$this->display ();
	}
	public $loginFbFields = array (
			'AppID',
			'AppSecret' 
	);
	public $loginFbFieldSettings = array (
			array (
					'index' => 'AppID',
					'type' => 'text',
					'label' => 'App ID' 
			),
			array (
					'index' => 'AppSecret',
					'type' => 'text',
					'label' => 'App Secret' 
			) 
	);
	public $loginGFields = array (
			'client_id',
			'client_secret',
			'developer_key',
			'redirect_url' 
	);
	public $loginGFieldSettings = array (
			array (
					'index' => 'client_id',
					'type' => 'text',
					'label' => 'Client ID' 
			),
			array (
					'index' => 'client_secret',
					'type' => 'text',
					'label' => 'Client Secret' 
			),
			array (
					'index' => 'developer_key',
					'type' => 'text',
					'label' => 'API Key' 
			),
			array (
					'index' => 'redirect_url',
					'type' => 'text',
					'label' => 'Redirect URIs' 
			) 
	);
	public function backupImageAction() {
		$this->initPage ()->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/index' )->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/menu', 'right' );
		
		// Create Backup image Folder
		$folder = 'backupfilemedia/';
		if (! is_dir ( $folder ))
			mkdir ( $folder, 0777, true );
		chmod ( $folder, 0777 );
		// get all file in tinymce
		$parent_files = glob ( '3rdparty/Filemanager/source/*' );
		$sub_files1 = glob ( '3rdparty/Filemanager/source/*/*' );
		$sub_files2 = glob ( '3rdparty/Filemanager/source/*/*/*' );
		
		// get all file in upload
		$parentUploadFiles = glob ( '3rdparty/uploads/*' );
		$subUploadFiles = glob ( '3rdparty/uploads/*/*' );
		
		$allfile = array_merge ( $parent_files ? $parent_files : array (), $sub_files1 ? $sub_files1 : array (), $sub_files2 ? $sub_files2 : array (), $parentUploadFiles ? $parentUploadFiles : array (), $subUploadFiles ? $subUploadFiles : array () );
		// increase script timeout value
		ini_set ( 'max_execution_time', 5000 );
		
		// create object
		$zip = new ZipArchive ();
		// set date
		if ($zip->open ( 'backupfilemedia/filebackup.zip', ZIPARCHIVE::CREATE ) !== TRUE) {
			die ( "Could not open archive" );
		}
		
		foreach ( $allfile as $key => $value ) {
			if (is_file ( $value )) {
				$zip->addFile ( $value );
			}
		}
		
		$zip->close ();
		pzk_notifier ()->addMessage ( 'Nén thành công' );
		$this->display ();
	}
}