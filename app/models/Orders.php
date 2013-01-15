<?php
namespace app\models;

class Orders extends \lithium\data\Model {

	protected $_schema = array(
		'_id'	=>	array('type' => 'id'),
		'datetime.date'	=>	array('type' => 'string', 'null' => false),
		'datetime.time'	=>	array('type' => 'string', 'null' => false),
		'email'	=>	array('type' => 'string', 'null' => false),
		'order_complete'	=>	array('type' => 'string', 'null' => false),		
		'user_id'	=>	array('type' => 'string', 'null' => false),		
		'vanity_amount'	=>	array('type' => 'double', 'null' => false),
		'vanity_length'	=>	array('type' => 'string', 'null' => false),
		'vanity_pattern'	=>	array('type' => 'string', 'null' => false),
		'vanity_payment_from'	=>	array('type' => 'string', 'null' => false),
		'vanity_type'	=>	array('type' => 'string', 'null' => false),
		'vanity_payment'	=>	array('type' => 'string', 'null' => false),				
	);


}
?>