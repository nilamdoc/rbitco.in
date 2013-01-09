<?php
namespace app\controllers;
use app\extensions\action\Functions;
use lithium\storage\Session;

class PointsController extends \lithium\action\Controller {

	public function index(){
	
		$user = Session::read('member');
		$function = new Functions();

		if(isset($user)){
			$countPointsBronze = $function->countPoints($user['_id'],'Bronze');
			if(count($countPointsBronze['points']['result'])==0){$pointsBronze = 0;}else{$pointsBronze=$countPointsBronze['points']['result'][0]['points'];}
			$countPointsSilver = $function->countPoints($user['_id'],'Silver');
			if(count($countPointsSilver['points']['result'])==0){$pointsSilver = 0;}else{$pointsSilver=$countPointsSilver['points']['result'][0]['points'];}					
			$countPointsBlack = $function->countPoints($user['_id'],'Black');
			if(count($countPointsBlack['points']['result'])==0){$pointsBlack = 0;}else{$pointsBlack=$countPointsBlack['points']['result'][0]['points'];}					
			
		}
	
	
		$function = new Functions();
		$countPointsAll = $function->countPointsAll();
		return compact('countPointsAll','pointsBronze','pointsSilver','pointsBlack');
	}
}
?>