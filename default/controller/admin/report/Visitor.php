<?php
class PzkAdminReportVisitorController extends PzkReportController
{
    public $table = 'visitor';
    public $title = 'Báo cáo khách viếng thăm';

	public $orderBy = '`y_time` asc, `m_time` asc, `d_time` asc';
	
    public $groupByColumns = array(
        array(
            'index' => 'y_time',
            'type' => 'normal',
            'label' => 'Năm'
        ),
		array(
            'index' => 'm_time',
            'type' => 'normal',
            'label' => 'Tháng'
        ),
		array(
            'index' => 'd_time',
            'type' => 'normal',
            'label' => 'Ngày'
        ),
		array(
            'index' => 'country',
            'type' => 'normal',
            'label' => 'Quốc gia'
        ),
		array(
            'index' => 'city',
            'type' => 'normal',
            'label' => 'Thành phố'
        ),
    );
    public $reportColumns = array(
        array(
            'index' => '*',
            'type' => 'count',
            'alias' => 'visitorCount',
            'label' => 'Số người viếng thăm'
        )
    );
	
	public $sortFields = array(
		'`y_time` asc, `m_time` asc, `d_time` asc'	=> 'Số lượt viếng thăm tăng',
		'`y_time` desc, `m_time` desc, `d_time` desc'	=> 'Số lượt viếng thăm giảm',
	);

    public $listFieldSettings = array(
        array(
            'index' => 'visitorCount',
            'label' => 'Số lượt khách viếng thăm'
        )
    );
	public $selectFields = 'count(*) as visitorCount';
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
        'subtitle' => 'Thống kê',
        'titley' => 'Số lượt khách viếng thăm'
    );
	
	public $showchart = true;
    public $gridDisplay = false;

}