<?php
namespace app\models;
use lithium\util\Validator;
use lithium\util\String;

class Urls extends \lithium\data\Model {

	protected $_schema = array(
		'_id'	=>	array('type' => 'id'),
		'address'	=>	array('type' => 'string', 'null' => false),
		'short'	=>	array('type' => 'string', 'null' => false),
	);

	protected $_meta = array(
		'key' => '_id',
		'locked' => true
	);

}

	Validator::add('short', function($value, $rule, $options) {
		$conflicts = Urls::count(array('short' => $value));
		if($conflicts) return false;
		return true;
	});

?>