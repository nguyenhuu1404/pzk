<?php
class PzkSGStoreStat extends PzkSGStoreLazy {
	public $arrAchievement = array(
		'rights' => 0, 
		'total' => 0,
		'totalPracticeQuestion' => 0, 
		'truePracticeQuestion' => 0, 
		'totalTestPrQuestion' => 0, 
		'trueTestPrQuestion'=>0,
		'totalTestQuestion'=>0, 
		'trueTestQuestion'=>0
	);
	public function log($table, $id) {
		$tables = $this->getTables();
		if(!$tables) $tables = array();
		if(!isset($tables[$table])) $tables[$table] = array();
		if(!isset($tables[$table][$id])) $tables[$table][$id] = array(
			'hits'	=>	0,
			'ips'	=> 	array()
		);
		$tables[$table][$id]['hits']++;
		$ip	= getRealIPAddress();
		if(!in_array($ip, $tables[$table][$id]['ips'])) {
			$tables[$table][$id]['ips'][] = $ip;
		}
		$this->setTables($tables);
	}
	
	
	public function updateIntoDatabase() {
		$tables = $this->getTables();
		foreach($tables as $table => $stats) {
			foreach($stats as $id => $stat) {
				$hit 		= $stat['hits'];
				$ips 		= $stat['ips'];
				$views 		= count($ips);
				$row = _db()->selectAll()->from($table)->whereId($id)->result_one();
				$updation = array(
					'views'		=> $row['views'] 	+ 	$views,
					'hits'		=> $row['hits']		+	$hit
				);
				_db()->update($table)->set($updation)->whereId($id)->result();
			}
		}
		$this->delTables();
	}
	
	public function logGame($userId, $rights, $total) {
		$users = $this->getUsers();
		if(!$users) $users = array();
		if(!isset($users[$userId])) $users[$userId] = $this->arrAchievement;
		$users[$userId]['rights'] +=  $rights;
		$users[$userId]['total'] +=  $total;
		
		$this->setUsers($users);
	}
	
	public function updateToAchievement(){
		$users = $this->getUsers();
		$week = date("W");
		$year = date("Y");
		
		if($users){
			foreach($users as $userId => $item){
				$rights = $item['rights'];
				$total = $item['total'];
				$totalPracticeQuestion = $item['totalPracticeQuestion'];
				$truePracticeQuestion = $item['truePracticeQuestion'];
				$totalTestPrQuestion = $item['totalTestPrQuestion'];
				$trueTestPrQuestion = $item['trueTestPrQuestion'];
				$totalTestQuestion = $item['totalTestQuestion'];
				$trueTestQuestion = $item['trueTestQuestion'];
				
				$entity = _db()->useCb()->getEntity('table')->setTable('achievement');
				$entity->loadWhere( array(
				'and',
					array('userId', $userId),
					array('week', $week),
					array('year', $year)
				) );
				if($entity->getId()){
					$row = $entity->getData();
					$updation = array(
						'rights'		=> $row['rights'] 	+ 	$rights,
						'total'		=> $row['total']		+	$total,
						'totalPracticeQuestion' => $row['totalPracticeQuestion'] + $totalPracticeQuestion,
						'truePracticeQuestion' => $row['truePracticeQuestion'] + $truePracticeQuestion,
						'totalTestPrQuestion' => $row['totalTestPrQuestion'] + $totalTestPrQuestion,
						'trueTestPrQuestion' => $row['trueTestPrQuestion'] + $trueTestPrQuestion,
						'totalTestQuestion' => $row['totalTestQuestion'] + $totalTestQuestion,
						'trueTestQuestion' => $row['trueTestQuestion'] + $trueTestQuestion
					);
					$entity->update($updation);
					$entity->save();
					
				}else{
					$updation = array(
						'userId' => $userId,
						'rights'		=> $rights,
						'total'		=> $total,
						'totalPracticeQuestion' => $totalPracticeQuestion,
						'truePracticeQuestion' =>  $truePracticeQuestion,
						'totalTestPrQuestion' =>  $totalTestPrQuestion,
						'trueTestPrQuestion' =>  $trueTestPrQuestion,
						'totalTestQuestion' =>  $totalTestQuestion,
						'trueTestQuestion' =>  $trueTestQuestion,
						'week' => $week,
						'year' => $year,
						'software' => pzk_request('softwareId')
					);
					$entity->setData($updation);
					$entity->save();
				}	
				
			}
		}
		
		$this->delUsers();
	}
	public function logPracticeQuestion($userId, $truePracticeQuestion, $totalPracticeQuestion) {
		$users = $this->getUsers();
		if(!$users) $users = array();
		if(!isset($users[$userId])) $users[$userId] = $this->arrAchievement;
		$users[$userId]['totalPracticeQuestion'] +=  $totalPracticeQuestion;
		$users[$userId]['truePracticeQuestion'] +=  $truePracticeQuestion;
		$this->setUsers($users);
	}
	public function logTestPrQuestion($userId, $trueTestPrQuestion, $totalTestPrQuestion) {
		$users = $this->getUsers();
		if(!$users) $users = array();
		if(!isset($users[$userId])) $users[$userId] = $this->arrAchievement;
		$users[$userId]['totalTestPrQuestion'] +=  $totalTestPrQuestion;
		$users[$userId]['trueTestPrQuestion'] +=  $trueTestPrQuestion;
		$this->setUsers($users);
	}
	public function logTestQuestion($userId, $trueTestQuestion, $totalTestQuestion) {
		$users = $this->getUsers();
		if(!$users) $users = array();
		if(!isset($users[$userId])) $users[$userId] = $this->arrAchievement;
		$users[$userId]['totalTestQuestion'] +=  $totalTestQuestion;
		$users[$userId]['trueTestQuestion'] +=  $trueTestQuestion;
		$this->setUsers($users);
	}
}