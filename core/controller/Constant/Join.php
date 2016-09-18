<?php
class PzkJoinConstant {
	public static $aqs_question = array(
		'table' 		=> 'aqs_question',
		'condition' 	=> '{replace}.questionId = aqs_question.id',
		'type' 		=> 'left'
	);
	public static $campaign = array(
		'table' 		=> 'campaign',
		'condition' 	=> '{replace}.campaignId = campaign.id',
		'type' 		=> 'left'
	);
	public static $category = array(
		'table' 		=> 'categories',
		'condition' 	=> '{replace}.categoryId = categories.id',
		'type' 			=> 'left'
	);
	public static $creator = array(
		'table' 		=> '`admin` as `creator`',
		'condition' 	=> '{replace}.creatorId = creator.id',
		'type' 			=> 'left'
	);
	public static $modifier = array(
		'table' 		=> '`admin` as `modifier`',
		'condition' 	=> '{replace}.modifiedId = modifier.id',
		'type' 			=> 'left'
	);
	public static $news = array(
		'table'		=> 	'news',
		'condition'	=> 	'{replace}.newsId = news.id',
		'type'		=> 'left'
	);
	public static $social_account = array(
		'table'		=> 	'social_account',
		'condition'	=> 	'social_schedule.accountId = social_account.id',
		'type'		=> 'left'
	);
	public static $social_app = array(
		'table'		=> 	'social_app',
		'condition'	=> 	'social_account.appId = social_app.id',
		'type'		=> 'left'
	);
	public static $featured = array(
		'table' 	=> 'featured',
		'condition' => '{replace}.featuredId = featured.id',
		'type' 		=> 'left'
	);
	public static $user = array(
		'table' 	=> 'user',
		'condition' => '{replace}.userId = user.id',
		'type' 		=> 'left'
	);
	public static function  get($field, $replace) {
		$dom = pzk_parse_selector($field);
		$tagName = $dom['tagName'];
		$result = self::$$tagName;
		foreach ($dom['attrs'] as $attr) {
			$result[$attr['name']] = $attr['value'];
		}
		$result['condition'] = str_replace('{replace}', $replace, $result['condition']);
		return $result;
	}
	
	public static function  gets($fields, $replace) {
		if(is_string($fields))
		$fields = explodetrim(',', $fields);
		$result = array();
		foreach($fields as $field) {
			$result[] = self::get($field, $replace);
		}
		return $result;
	}
}
?>