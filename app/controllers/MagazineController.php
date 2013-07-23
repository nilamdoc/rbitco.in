<?php
namespace app\controllers;
use app\models\Articles;
use app\models\Users;
use lithium\storage\Session;
use app\extensions\action\Functions;

class MagazineController extends \lithium\action\Controller {

	public function index(){
		$this->render(array('layout' => 'magazine'));
	}
	
	public function edit($permalink = null){
		$this->render(array('layout' => 'magazine'));
	}

	public function add(){
		$user = Session::read('default');
		if ($user==""){	return $this->redirect('Magazine::index');}
		$admin  = Users::find('first',array(
			'conditions' => array('username'=>$user['username']),
			'fields'=> array('username','admin')
		));
		if($admin['admin']!='Yes'){return $this->redirect('Magazine::index');}
		$article = Articles::create();
		if(($this->request->data) && $article->save($this->request->data)) {	
			return $this->redirect('Magazine::edit');
		}
		
		$this->render(array('layout' => 'magazine'));
				
		
	}

	public function article($permalink = null){
		$this->render(array('layout' => 'magazine'));
	}

	public function admin($permalink = null){
		$this->render(array('layout' => 'magazine'));
	}


}
?>