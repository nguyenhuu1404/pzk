<?php
class PzkAdminServicePackagesController extends PzkGridAdminController {
	public $addFields 	= 'id, serviceName, amount, software';
	public $editFields 	= 'id, serviceName, amount, software';
	public $table		=	'service_packages';
	public $sortFields 	= array(
		'id asc' 			=> 'ID tăng',
		'id desc' 			=> 'ID giảm',
		'serviceName asc' 	=> 'Tên dịch vụ tăng',
		'serviceName desc' 	=> 'Tên dịch vụ giảm',
		'date asc' 			=> 'Ngày nhập tăng',
		'date desc' 		=> 'Ngày nhập giảm',
		'amount asc' 		=> 'Đơn giá tăng',
		'amount desc' 		=> 'Đơn giá giảm'
	);
	public $searchFields = array('serviceName, id, amount');
	public $listFieldSettings = array(
		array(
			'index' 		=> 'serviceName',
			'type' 			=> 'text',
			'label' 		=> 'Tên dịch vụ'
		),
		array(
			'index' 		=> 'amount',
			'type' 			=> 'price',
			'label' 		=> 'Đơn giá'
		),
		array(
			'index' 		=> 'created',
			'type' 			=> 'datetime',
			'label' 		=> 'Ngày nhập',
			'format'		=> 'd/m/Y H:i:s'
		),
		array(
			'index' 		=> 'modified',
			'type' 			=> 'datetime',
			'label' 		=> 'Ngày sửa',
			'format'		=> 'd/m/Y H:i:s'
		),
		array(
			'index' 		=> 'status',
			'type' 			=> 'status',
			'label' 		=> 'Trạng thái'
		),
	);
	public $addLabel = 'Thêm mới';
	public $addFieldSettings = array(
		array(
			'index' 		=> 'serviceName',
			'type' 			=> 'text',
			'label' 		=> 'Tên dịch vụ'
		),
		array(
			'index' 		=> 'amount',
			'type' 			=> 'text',
			'label' 		=> 'Đơn giá'
		)
	);
	public $editFieldSettings = array(
		array(
			'index' 		=> 'serviceName',
			'type' 			=> 'text',
			'label' 		=> 'Tên dịch vụ'
		),
		array(
			'index' 		=> 'amount',
			'type' 			=> 'text',
			'label' 		=> 'Đơn giá'
		),

	);
	public $addValidator = array(
		'rules' => array(
			'serviceName' 	=> array(
				'required' 	=> true
			),
			'amount' => array(
				'required' 	=> true
				
			)

		),
		'messages' => array(
			'serviceName' 	=> array(
				'required' 	=> 'Tên dịch vụ không được để trống'
				
			),
			'amount' => array(
				'required' 	=> 'Đơn giá không được để trống'
				
			)
		)
	);
	public $editValidator = array(
		'rules' => array(
			'serviceName' 	=> array(
				'required' 	=> true
			),
			'amount' 		=> array(
				'required' 	=> true
				
			)

		),
		'messages' => array(
			'serviceName' 	=> array(
				'required' 	=> 'Tên dịch vụ không được để trống'
				
			),
			'amount' => array(
				'required' 	=> 'Đơn giá không được để trống'
				
			)
		)
	);

}