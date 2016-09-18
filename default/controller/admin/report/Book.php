<?php
class PzkAdminReportBookController extends PzkReportController
{
    public $table = 'user_book';
    public $title = 'Báo cáo vở bài tập';

	public $sortFields = array(
		'bookCount asc'	=> 'Số lần làm tăng',
		'bookCount desc'	=> 'Số lần làm giảm'
	);
    public $groupByColumns = array(
        array(
            'index' => 'startTime',
            'type' => 'datetime',
            'label' => 'Ngày làm',
            'formatType' => array(
                'day'  => 'Ngày',
                'month'  => 'Tháng',
                'year'  => 'Năm',
                'weekday' => 'Thứ',
                'hour'  => 'Giờ'
            )
        ),
        array(
            'index' => 'categoryId',
            'type' => 'normal',
            'label' => 'Dạng bài tập',
            'condition' => array(
                'table' => 'categories',
                'value' => 'id',
                'show'  => 'name'
            )
        ),
        array(
            'index' => 'teacherId',
            'type' => 'normal',
            'label' => 'Giáo viên',
            'condition' => array(
                'table' => 'admin',
                'value' => 'id',
                'show'  => 'name'
            )
        ),
        array(
            'index' => 'isRequest',
            'type' => 'normal',
            'label' => 'Yêu cầu chấm'
        ),
        array(
            'index' => 'status',
            'type' => 'normal',
            'label' => 'Trạng thái'
        )
    );
    public $reportColumns = array(
        array(
            'index' => '*',
            'type' => 'count',
            'alias' => 'bookCount',
            'label' => 'Số lần làm'
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
        'titley' => 'Số lần làm'
    );
	
	public $showchart = true;
    public $gridDisplay = true;

}