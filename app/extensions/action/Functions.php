<?php
namespace app\extensions\action;

use lithium\storage\Session;
use app\extensions\action\Controller;
use app\models\Users;
use app\models\Details;
use app\models\Payments;
use app\models\Points;
use app\models\Messages;
use app\models\Accounts;
use app\models\Interests;
use app\models\Transactions;
use lithium\data\Connections;

class Functions extends \lithium\action\Controller {

	public function roman($integer, $upcase = true){
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0){
			foreach($table as $rom=>$arb){
				if($integer >= $arb){
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}
		return $return;
	} 

	public function getBitAddress($account){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
	  	  $wallet['address'] = $bitcoin->getaddressesbyaccount($account);
		  $wallet['balance'] = $bitcoin->getbalance($account);
		  $wallet['key'] = $account; 
		return compact('wallet');
	}
	public function sendAmount($fromAccount, $toAddress, $amount, $flag = 1, $message){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		
		$sendAmount = $bitcoin->sendfrom($fromAccount, $toAddress, $amount, $flag, $message);
		return compact('sendAmount');
	}

	public function gettransactions($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
		$json = file_get_contents('http://blockexplorer.com/q/mytransactions/'.$address, false, $context);
//			print_r($json);
			$jdec = json_decode($json);
//			print_r($jdec);
//			$rate = $jdec->{'ticker'}->{'avg'};
			return (array)$jdec;
	}

	public function addressfirstseen($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/addressfirstseen/'.$address, false, $context);
			return $json;
	}

	public function addressbalance($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/addressbalance/'.$address, false, $context);
			return $json;
	}

	function get_ip_address() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}

	public function ip_location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://api.hostip.info/get_json.php?ip='.$ip.'&position=true', false, $context);
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
	
	public function ip2location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			//http://api.ipinfodb.com/v3/ip-city/?key=40b69b063becff17998e360d05f48a31814a8922db3f33f5337ceb45542e2b42&ip=74.125.45.100&format=json
			$json = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key='.IP_INFO_DB.'&ip='.$ip.'&format=json', false, $context);
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
		

	public function toFriendlyTime($seconds) {
	  $measures = array(
		'day'=>24*60*60,
		'hour'=>60*60,
		'minute'=>60,
		'second'=>1,
		);
	  foreach ($measures as $label=>$amount) {
		if ($seconds >= $amount) {  
		  $howMany = floor($seconds / $amount);
		  return $howMany." ".$label.($howMany > 1 ? "s" : "");
		}
	  } 
	  return "now";
	}   

	public function getChilds($user_id){
	#Retrieving a Full Tree
	/* 	SELECT node.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
		   AND parent.user_id = 3
	ORDER BY node.lft;
	
	parent = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: parent.left, $lt: parent.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
		$ParentDetails = Details::find('all',array(
			'conditions'=>array(
			'user_id' => $user_id
			)));

		foreach($ParentDetails as $pd){
			$left = $pd['left'];
			$right = $pd['right'];
		}
		$NodeDetails = Details::find('all',array(
			'conditions' => array(
				'left'=>array('$gt'=>$left),
				'right'=>array('$lt'=>$right)
			)),
			array('order'=>array('left'=>'ASC'))
		);
		return $NodeDetails;
	}
	
	public function countChilds($user_id){
	#Retrieving a Full Tree
	/* 	SELECT node.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
		   AND parent.user_id = 3
	ORDER BY node.lft;
	
	parent = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: parent.left, $lt: parent.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
		$ParentDetails = Details::find('all',array(
			'conditions'=>array(
			'user_id' => $user_id
			)));
		foreach($ParentDetails as $pd){
			$left = $pd['left'];
			$right = $pd['right'];
		}
		$NodeDetails = Details::count(array(
			'conditions' => array(
				'left'=>array('$gt'=>$left),
				'right'=>array('$lt'=>$right)
			))
		);
		return $NodeDetails;
	}
	
	public function getParents($user_id){
	#Retrieving a Single Path above a user
	/* SELECT parent.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.user_id = 10
	ORDER BY node.lft;
	
	node = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: node.left, $lt: node.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
			$NodeDetails = Details::find('all',array(
				'conditions'=>array(
				'user_id' => $user_id
			)));
			foreach($NodeDetails as $pd){
				$left = $pd['left'];
				$right = $pd['right'];
			}
			$ParentDetails = Details::find('all',array(
				'conditions' => array(
					'left'=>array('$lt'=>$left),
					'right'=>array('$gt'=>$right)
				)),
				array('order'=>array('left'=>'ASC'))
			);
		return $ParentDetails;
	}	

	public function countParents($user_id){
	#Retrieving a Single Path above a user
	/* SELECT parent.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.user_id = 10
	ORDER BY node.lft;
	
	node = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: node.left, $lt: node.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
			$NodeDetails = Details::find('all',array(
				'conditions'=>array(
				'user_id' => $user_id
			)));
			foreach($NodeDetails as $pd){
				$left = $pd['left'];
				$right = $pd['right'];
			}
			$ParentDetails = Details::count(array(
				'conditions' => array(
					'left'=>array('$lt'=>$left),
					'right'=>array('$gt'=>$right)
				))
			);
		return $ParentDetails;
	}	

	public function returnName($refer_id){
		$refername = Users::find('first',array(
			'fields'=>array('firstname','lastname'),
			'conditions'=>array('_id'=>$refer_id)
		));
		return $refername['firstname'];
	}

	public function countMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array('refer_id'=>$id,
			'read'=>"0")
		));
		return compact('count');
	}
	public function countMailSentTodayUser($user_id = null,$refer_id = null){
		if($user_id =='' || $refer_id == ''){return false;}
		$countMessages = Messages::count(array(
			'conditions'=>array(
				'refer_id'=>$refer_id,
				'user_id'=>$user_id,
				'datetime.date'=> gmdate('Y-m-d',time())
			)
		));
		return compact('countMessages');
	}
	public function countReadMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array(
				'refer_id'=>$id,
				'read'=>1)
		));
		return compact('count');
	}
	public function countSendMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array(
				'user_id'=>$id,
				)
		));
		return compact('count');
	}

	public function getMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getMails = Messages::find('all',array(
			'conditions'=>array('refer_id'=>$id,
			'read'=>"0")
		));
		return $getMails;
	}
	
	public function getSendMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getSendMails = Messages::find('all',array(
			'conditions'=>array('user_id'=>$id)
		));
		return $getSendMails;
	}
	public function getSendMailsToday($refer_id){
		$user = Session::read('member');
		$id = $user['_id'];
		$getSendMails = Messages::find('all',array(
			'conditions'=>array('user_id'=>$id)
		));
		return $getSendMails;
	}	
	public function getReadMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getReadMails = Messages::find('all',array(
			'conditions'=>array(
				'refer_id'=>$id,
				'read'=>1)
		));
		return $getReadMails;
	}

	public function addPoints($user_id=null,$type=null,$for=null, $reply=null,$txid=null,$address=null){
	if($user_id=="" || $type=="" || $for==""){return false;}
			$username= $this->returnName($user_id);
		$data = array(
			'user_id' => $user_id,
			'name' => $username,
			'type' => $type,
			'for' => $for,
			'points' =>$reply,
			'datetime.date'=> gmdate('Y-m-d',time()),
			'datetime.time'=> gmdate('h:i:s',time()),
			'txid'=>$txid,
			'address'=>$address,

		);
		Points::create()->save($data);
		return true;
	}
	
	public function countPoints($user_id=null, $type=null){
		if($user_id==null){return array('count'=>0);}
		
		$mongodb = Connections::get('default')->connection;
		$points = Points::connection()->connection->command(array(
      'aggregate' => 'points',
      'pipeline' => array( 
                        array( '$project' => array(
                            '_id'=>0,
                            'points' => '$points',
                            'type' => '$type',
							'user_id'=>'$user_id'
                        )),

						array('$match'=>array('user_id'=>$user_id,'type'=>$type)),							
						array('$group' => array( '_id' => array(
                                'type'=>'$type',
								'user_id'=>'$user_id'
                            ),
                            'points' => array('$sum' => '$points'),  

                        )),
                    )
    ));
		return compact('points'); 
	}

	public function countPointsAll(){
	
		$mongodb = Connections::get('default')->connection;
		$points = Points::connection()->connection->command(array(
			'aggregate' => 'points',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'points' => '$points',
					'type' => '$type',
					'user_id'=>'$user_id',
					'name'=>'$name'							
				)),

				array('$group' => array( '_id' => array(
						'type'=>'$type',
						'user_id'=>'$user_id',
						'name'=>'$name'															
						),
					'points' => array('$sum' => '$points'),  
				)),
				array('$sort'=>array(
					'points'=>-1,
				))
				
			)
		));
		return compact('points'); 
	}

	public function sumInterest($user_id){
	
		$mongodb = Connections::get('default')->connection;
		$interest = Interests::connection()->connection->command(array(
			'aggregate' => 'interests',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'interest' => '$interest',
					'user_id'=>'$user_id',
					'name'=>'$name'							
				)),
				array('$match'=>array('user_id'=>$user_id)),
				array('$group' => array( '_id' => array(
						'user_id'=>'$user_id',
						'name'=>'$name'															
						),
					'interest' => array('$sum' => '$interest'),  
				)),
			)
		));
		return compact('interest'); 
	}


	public function getBalance($username){
		$wallet = array();
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');			
		$wallet['address'] = $bitcoin->getaddressesbyaccount($username);	
		$wallet['balance'] = $bitcoin->getbalance($username);
		$wallet['key'] = $username; 
		return compact('wallet');
	}

	public function listTransactions($username,$address){
		$transactions = Transactions::find('all',array(
				'conditions'=>array('address'=>$address),
				'order'=> array('blocktime'=>'DESC'),
		));
		return compact('transactions');
	}
	public function array_sort($arr){
		if(empty($arr)) return $arr;
		foreach($arr as $k => $a){
			if(!is_array($a)){
				arsort($arr); // could be any kind of sort
				return $arr;
			}else{
				$arr[$k] = Functions::array_sort($a);
			}
		}
		return $arr;
	}
}
?>