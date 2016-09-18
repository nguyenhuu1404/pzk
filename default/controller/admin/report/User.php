<?php
class PzkAdminReportUserController extends PzkReportController
{
    public $table = 'user';
    public $title = 'Báo cáo user';
	public $orderBy = '`user`.`registered` asc';
	public $sortFields = array(
		'`user`.id asc' => 'ID tăng',
		'`user`.id desc' => 'ID giảm',
		'`user`.`name` asc' => 'Tên tăng',
		'`user`.`name` desc' => 'Tên giảm',
		'`user`.`username` asc' => 'Username tăng',
		'`user`.`username` desc' => 'Username giảm',
		'`user`.`registered` asc' => 'Registered tăng',
		'`user`.`registered` desc' => 'Registered giảm',
	);


    public $groupByColumns = array(
        array(
            'index' => 'registered',
            'type' => 'datetime',
            'label' => 'Ngày tạo',
            'formatType' => array(
                'day'  => 'Ngày',
                'month'  => 'Tháng',
                'year'  => 'Năm',
                'weekday' => 'Thứ',
                'hour'  => 'Giờ'
            )
        ),
        array(
            'index' => 'areacode',
            'type' => 'normal',
            'label' => 'Vùng',
            'condition' => array(
                'table' => 'areacode',
                'value' => 'id',
                'show'  => 'name'
            )
        )
    );
    public $reportColumns = array(
        array(
            'index' => '*',
            'type' => 'count',
            'alias' => 'userCount',
            'label' => 'Số người đăng ký'
        )
    );

    public $listFieldSettings = array(
        array(
            'index' => 'username',
            'label' => 'Tên tài khoản'
        ),
		array(
			'index' => 'phone',
			'label' => 'Số điện thoại'
		),
        array(
            'index' => 'email',
            'label' => 'Địa chỉ mail'
        ),
        array(
            'index' => 'address',
            'label' => "Địa chỉ"
        ),
        array(
            'index' => 'registered',
            'label' => 'Ngày tạo'
        )
    );

	public $typeChart = array(
        array(
            'index' => 'Dạng cột',
            'value' => 'column'
        ),
        array(
            'index' => 'Dạng dòng',
            'value' => 'line'
        ),
        array(
            'index' => 'AREA',
            'value' => 'area'
        ),
        array(
            'index' => 'SPLINE',
            'value' => 'spline'
        ),
        array(
            'index' => 'Bar',
            'value' => 'bar'
        )
        //array(
        //    'index' => 'PIE',
        //    'value' => 'pie'
        //)
    );
	
	public $configChart = array(
        'title' => 'Báo cáo',
        'subtitle' => 'Tháng',
        'titley' => 'Số người dùng'
    );
	
	public $showchart = true;
    public $gridDisplay = true;

}