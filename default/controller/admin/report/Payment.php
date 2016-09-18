<?php
class PzkAdminReportPaymentController extends PzkReportController
{
    public $table 	= 'history_payment';
    public $title 	= 'Báo cáo Thanh toán';
	public $orderBy = '`history_payment`.`created` asc';
	public $sortFields = array(
		'`history_payment`.id asc' 			=> 'ID tăng',
		'`history_payment`.id desc' 		=> 'ID giảm',
		'`history_payment`.`created` asc' 	=> 'Ngày mua tăng',
		'`history_payment`.`created` desc' 	=> 'Ngày mua giảm',
	);


    public $groupByColumns = array(
        array(
            'index' 	=> 'created',
            'type' 		=> 'datetime',
            'label' 	=> 'Ngày tạo',
            'formatType' 	=> array(
                'day'  		=> 'Ngày',
                'month'  	=> 'Tháng',
                'year'  	=> 'Năm',
                'weekday' 	=> 'Thứ',
                'hour'  	=> 'Giờ'
            )
        )
    );
    public $reportColumns = array(
        array(
            'index' 	=> '*',
            'type' 		=> 'count',
            'alias' 	=> 'userCount',
            'label' 	=> 'Số người mua'
        ),
		array(
            'index' => 'amount',
            'type' => 'sum',
            'alias' => 'totalAmount',
            'label' => 'Tổng tiền'
        )
    );

    public $listFieldSettings = array(
        array(
            'index' => 'username',
            'label' => 'Tên tài khoản'
        ),
        array(
            'index' => 'created',
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
        'title' 		=> 'Báo cáo',
        'subtitle' 		=> 'Tháng',
        'titley' 		=> 'Số người mua'
    );
	
	public $showchart 	= true;
    public $gridDisplay = true;

}