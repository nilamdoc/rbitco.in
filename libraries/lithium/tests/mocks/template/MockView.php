<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\tests\mocks\template;

class MockView extends \lithium\template\View {

	public function renderer() {
		return $this->_config['renderer'];
	}
}

?>