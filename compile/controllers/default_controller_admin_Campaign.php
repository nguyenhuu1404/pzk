<?php
class PzkDefaultAdminCampaignController extends PzkGridAdminController {
	public $title = 'Quản lý chiến dịch';
	public $table = 'campaign';
	public function getJoins() {
		return PzkJoinConstant::gets('creator, modifier', 'campaign');
	}
	public $selectFields = 'campaign.*, creator.name as creatorName, modifier.name as modifiedName';
	public $orderBy = 'campaign.id desc';
	public function getListFieldSettings() { 
		return array(
			PzkListConstant::get('name', 'campaign'),
			PzkListConstant::get('startDate', 'campaign'),
			PzkListConstant::get('endDate', 'campaign'),
			PzkListConstant::get('status', 'campaign'),
			array(
				'index'	=> 'none4',
				'type'	=> 'group',
				'label'	=> '<br />Người tạo<br />Người sửa',
				'delimiter'	=> '<br />',
				'fields'	=> array(
					PzkListConstant::get('creatorName', 'campaign'),
					PzkListConstant::get('modifiedName', 'campaign'),
				)
			),
			array(
				'index'	=> 'none5',
				'type'	=> 'group',
				'label'	=> '<br />Ngày tạo<br />Ngày sửa',
				'delimiter'	=> '<br />',
				'fields'	=> array(
					PzkListConstant::get('created', 'campaign'),
					PzkListConstant::get('modified', 'campaign'),
				)
			),
		);
	}
	
	public $searchFields = array('`campaign`.name','`categories`.name');
	public $searchLabel = 'Tìm kiếm';
	
	public function getSortFields() {
		return PzkSortConstant::gets('id, name, created', 'campaign');
	}
	
	public $logable = true;
	public $logFields = 'name, created, startDate, endDate, expectedRegister, expectedBuyer, expectedApproach, expectedRevenue, cost';
	
	public $addFields = 'name, content, created, startDate, endDate, expectedRegister, expectedBuyer, expectedApproach, expectedRevenue, cost, status';
	public $editFields = 'name, content, created, startDate, endDate, expectedRegister, expectedBuyer, expectedApproach, expectedRevenue, cost, status';	
	
	public $viewFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên chiến dịch',
			'link' => '/admin_campaign/stat/'
        ),
		array(
			'index'	=> 'created',
			'type'	=> 'text',
			'label'	=> 'Ngày tạo'
		),
		array(
			'index'	=> 'startDate',
			'type'	=> 'text',
			'label'	=> 'Ngày bắt đầu'
		),
		array(
			'index'	=> 'endDate',
			'type'	=> 'text',
			'label'	=> 'Ngày kết thúc'
		),
		array(
            'index' => 'expectedRegister',
            'type' => 'text',
            'label' => 'Số người đăng ký dự kiến'
        ),
		array(
			'index'	=> 'expectedBuyer',
			'type'	=> 'text',
			'label'	=> 'Số người mua dự kiến'
		),
		array(
			'index'	=> 'expectedApproach',
			'type'	=> 'text',
			'label'	=> 'Số lượt tiếp cận dự kiến'
		),
		array(
			'index'	=> 'expectedRevenue',
			'type'	=> 'price',
			'label'	=> 'Doanh thu dự kiến'
		),
		array(
			'index'	=> 'cost',
			'type'	=> 'price',
			'label'	=> 'Chi phí'
		),
		array(
			'index'	=> 'totalApproach',
			'type'	=> 'text',
			'label'	=> 'Tổng số người tiếp cận'
		),
		array(
            'index' => 'totalRegister',
            'type' => 'text',
            'label' => 'Tổng số người đăng ký'
        ),
		array(
			'index'	=> 'totalBuyer',
			'type'	=> 'text',
			'label'	=> 'Tổng số người mua'
		),
		array(
			'index'	=> 'totalBuyerThitai',
			'type'	=> 'text',
			'label'	=> 'Tổng số người mua thitai.vn'
		),
		array(
			'index'	=> 'totalRevenue',
			'type'	=> 'price',
			'label'	=> 'Tổng doanh thu'
		),
		array(
			'index'	=> 'viewPage',
			'type'	=> 'text',
			'label'	=> 'Tổng số lượt view trang'
		),
		array(
			'index'	=> 'bannerClick',
			'type'	=> 'text',
			'label'	=> 'Tổng số click vào banner'
		),
		array(
			'index'	=> 'newsClick',
			'type'	=> 'text',
			'label'	=> 'Tổng số click đọc tin tức'
		),
		array(
			'index'	=> 'newsletterClick',
			'type'	=> 'text',
			'label'	=> 'Tổng số click từ Newsletter'
		),
		array(
			'index'	=> 'fbClick',
			'type'	=> 'text',
			'label'	=> ' Tổng số click từ lịch đăng tường facebook'
		),
		array(
			'index'	=> 'revenueExpectedPercent',
			'type'	=> 'text',
			'label'	=> ' % Đạt doanh thu'
		),
		array(
			'index'	=> 'runningPercent',
			'type'	=> 'text',
			'label'	=> ' % Tiến độ'
		),
		array(
			'index'	=> 'stat',
			'type'	=> 'link',
			'label'	=> ' Thống kê',
			'link'	=> '/admin_campaign/stat/'
		)
		
	);
	
	public function getChildrenGridSettings() {
		return array(
			array(
				'index'	=> 'news',
				'title'	=> 'Tin tức',
				'label'	=> 'Tin tức',
				'table'	=> 'news',
				'addLabel'	=> 'Thêm tin tức',
				'quickMode'	=> false,
				'module'	=> 'news',
				'parentField'	=> 'campaignId',
				'joins' => PzkJoinConstant::gets('category, campaign, creator, modifier', 'news'),
				'fields' => 'news.*, categories.name as categoryName, campaign.name as campaignName, creator.name as creatorName, modifier.name as modifiedName',
				'filterStatus' => true,

				'sortFields' => PzkSortConstant::gets('id, title, categoryId, ordering', 'news'),
				'orderBy'	=> 'news.id desc',
				'searchFields' => array('`news`.title', '`news`.alias', '`categories`.name', '`campaign`.name'),
				'Searchlabels' => 'Tên ứng dụng',
				'listFieldSettings'	=> array(
					PzkListConstant::get('img', 'news'),
					PzkListConstant::group('<br />Tiêu đề<br />Bí danh', 'title, alias', 'news'),
					PzkListConstant::group('<br />Từ khóa<br />Mô tả', 'meta_keywords, meta_description', 'news'),
					PzkListConstant::get('categoryName', 'news'),
					PzkListConstant::get('campaignName', 'news'),
					PzkListConstant::group('<br />Xem<br />Thích<br />Bình luận', 'views, likes, comments', 'news'),
					PzkListConstant::group('<br />Người tạo<br />Người sửa', 'creatorName, modifiedName', 'news'),
					PzkListConstant::group('<br />Ngày tạo<br />Ngày sửa', 'created, modified', 'news'),
					PzkListConstant::group('<br />Ngày bắt đầu<br />Ngày kết thúc', 'startDate, endDate', 'news'),
					PzkListConstant::get('ordering', 'news'),
					PzkListConstant::get('status', 'news'),
				)
			)
		);	
	} 
	
	public function getParentDetailSettings() { 
		return array(
			PzkParentConstant::get('creator', 'featured'),
			PzkParentConstant::get('modifier', 'featured')
		);
	}
    public $addLabel = 'Thêm chiến dịch';
    public $addFieldSettings = array(
        array(
            'index' 	=> 'name',
            'type' 		=> 'text',
            'label' 	=> 'Tên chiến dịch',
        	'mdsize'	=>	3
        ),
		array(
			'index'	=> 'created',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày tạo',
        	'mdsize'	=>	3
		),
		array(
			'index'	=> 'startDate',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày bắt đầu',
        	'mdsize'	=>	3
		),
		array(
			'index'	=> 'endDate',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày kết thúc',
        	'mdsize'	=>	3
		),
		array(
            'index' => 'expectedRegister',
            'type' => 'text',
            'label' => 'Số người đăng ký dự kiến',
        	'mdsize'	=>	3
        ),
		array(
			'index'	=> 'expectedBuyer',
			'type'	=> 'text',
			'label'	=> 'Số người mua dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'expectedApproach',
			'type'	=> 'text',
			'label'	=> 'Số lượt tiếp cận dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'expectedRevenue',
			'type'	=> 'text',
			'label'	=> 'Doanh thu dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'cost',
			'type'	=> 'text',
			'label'	=> 'Chi phí',
			'mdsize'	=>	3
		),
    		array(
    				'index'	=> 'content',
    				'type'	=> 'tinymce',
    				'label'	=> 'Nội dung',
    				'mdsize'	=>	12
    		)
    );
    public $editFieldSettings = array(
		array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên chiến dịch',
			'mdsize'	=>	3
        ),
		array(
			'index'	=> 'created',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày tạo',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'startDate',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày bắt đầu',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'endDate',
			'type'	=> 'datepicker',
			'format' => 'd/m/Y',
			'label'	=> 'Ngày kết thúc',
			'mdsize'	=>	3
		),
		array(
            'index' => 'expectedRegister',
            'type' => 'text',
            'label' => 'Số người đăng ký dự kiến',
			'mdsize'	=>	3
        ),
		array(
			'index'	=> 'expectedBuyer',
			'type'	=> 'text',
			'label'	=> 'Số người mua dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'expectedApproach',
			'type'	=> 'text',
			'label'	=> 'Số lượt tiếp cận dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'expectedRevenue',
			'type'	=> 'text',
			'label'	=> 'Doanh thu dự kiến',
			'mdsize'	=>	3
		),
		array(
			'index'	=> 'cost',
			'type'	=> 'text',
			'label'	=> 'Chi phí',
			'mdsize'	=>	3
		),
    		array(
    				'index'	=> 'content',
    				'type'	=> 'tinymce',
    				'label'	=> 'Nội dung',
    				'mdsize'	=>	12
    		)
    );
	public function statAction($id){
		$campaign =_db()->select('*')->from('campaign')
			->where(array('id', $id))->result_one();
		
		// so nguoi dang ky tai khoan
		$registered =_db()->useCB()->select('count(*) as c')->from('user')
			->gteRegistered($campaign['startDate'])
			->lteRegistered($campaign['endDate'])->result_one();
		$registered = $registered['c'];
		
		// so nguoi mua
		
		if(pzk_request('app') == 'nobel_test') {
			$totalbuy = _db()->useCB()->select('count(*) as c')->from('history_payment')
			->gteDatepayment($campaign['startDate'])
			->lteDatepayment($campaign['endDate'])
			->whereStatus(2)
			->result_one();
			$totalbuy = $totalbuy['c'];
			
			$totalbuyThitai = _db()->useCB()->select('count(*) as c')->from('history_payment_test')
			->gteDatepayment($campaign['startDate'])
			->lteDatepayment($campaign['endDate'])
			->whereStatus(2)
			->result_one();
			$totalbuyThitai = $totalbuyThitai['c'];
			
			// doanh thu
			$revenue =_db()->useCB()->select('sum(amount) as totalAmount')->from('history_payment')
			->gteDatepayment($campaign['startDate'])
			->lteDatepayment($campaign['endDate'])
			->whereStatus(2)
			->result_one();
			
			// doanh thu thitai.vn
			$revenueThitai =_db()->useCB()->select('sum(amount) as totalAmount')->from('history_payment_test')
			->gteDatepayment($campaign['startDate'])
			->lteDatepayment($campaign['endDate'])
			->whereStatus(2)
			->result_one();
			$revenue = $revenue['totalAmount'] + $revenueThitai['totalAmount'];
		} else {
			$totalbuy = _db()->useCB()->select('count(*) as c')->from('order')
			->gteOrderDate($campaign['startDate'])
			->lteOrderDate($campaign['endDate'])->result_one();
			$totalbuy = $totalbuy['c'];
			
			// doanh thu
			$revenue = _db()->useCB()->select('sum(amount) as totalAmount')->from('order_transaction')
			->gtePaymentDate($campaign['startDate'])
			->ltePaymentDate($campaign['endDate'])->result_one();
			$revenue = $revenue['totalAmount'];
		}
		
		// so nguoi doc tin tuc
		$viewnews =_db()->useCB()->select('count(distinct(ip)) as c')->from('news_visitor')
			->gteVisited($campaign['startDate'])
			->lteVisited($campaign['endDate'])->result_one();
		$viewnews = $viewnews['c'];
		
		// so nguoi click vao banner
		$bannerid = _db()->useCB()->select('id')->from('banner')
			->where(array('campaignId', $id))->result_one();
		
		$click = _db()->useCB()->select('count(*) as c')->from('banner_click')
			->where(array('bannerId',$bannerid['id']))
			->gteTimeclick($campaign['startDate'])
			->lteTimeclick($campaign['endDate'])->result_one();
		$click = $click['c'];
		
		// so nguoi truy cap website
		$viewweb = _db()->useCB()->select('count(distinct(ip)) as c')->from('visitor')
			->gteVisited($campaign['startDate'])
			->lteVisited($campaign['endDate'])->result_one();
		$totalApproach = $viewweb['c'];
		$viewweb = _db()->useCB()->select('count(ip) as c')->from('visitor')
		->gteVisited($campaign['startDate'])
		->lteVisited($campaign['endDate'])->result_one();
		$viewweb = $viewweb['c'];
		
		$revenueExpectedPercent = $revenue/ $campaign['expectedRevenue'] * 100;
		$campaignDuration = dateDifference($campaign['startDate'], $campaign['endDate']);
		$runningDuration = dateDifference($campaign['startDate'], date('Y-m-d'));
		if($runningDuration > $campaignDuration) {
			$runningDuration = $campaignDuration;
		}
		$runningPercent = $runningDuration / $campaignDuration * 100;
		$updatedata = array(
			'totalRegister' 			=> $registered, 
			'totalBuyer' 				=> $totalbuy, 
			'totalBuyerThitai'			=> $totalbuyThitai,
			'totalRevenue' 				=> $revenue, 
			'totalApproach' 			=> $totalApproach,
			'viewPage' 					=> $viewweb, 
			'newsClick' 				=> $viewnews,
			'revenueExpectedPercent'	=> $revenueExpectedPercent . '%',
			'runningPercent'			=> $runningPercent . '%'
		);
		$updatedata = _db()->buildInsertData('campaign', $updatedata);
		 _db()->update('campaign')
			->set($updatedata)
			->whereId($id)->result();
		$this->redirect('view/' . $id);
	}
	
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
	$datetime1 = date_create($date_1);
	$datetime2 = date_create($date_2);

	$interval = date_diff($datetime1, $datetime2);

	return $interval->format($differenceFormat) + 1;

}
	
?>