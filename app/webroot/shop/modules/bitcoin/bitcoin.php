<?php

if (!defined('_CAN_LOAD_FILES_'))
    exit;

class Bitcoin extends PaymentModule {

    private $_html = '';
    private $_postErrors = array();

    public function __construct() {
        $this->name = 'bitcoin';
        $this->tab = 'payments_gateways';
        $this->version = '0.1.1';
        $this->author = '-X-erOs';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        parent::__construct();

        $this->displayName = $this->l('Bitcoin');
        $this->description = $this->l('Module for accepting payments by bitcoin.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall ?');
        
        $addr = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_address WHERE  `state` =  "available"');
 
        if (count($addr) > 0)
        	Configuration::updateValue('BITCOIN_ADDRESS_AVAILABLE', true);
        else
		Configuration::updateValue('BITCOIN_ADDRESS_AVAILABLE', false);
		
        if (!sizeof(Currency::checkPaymentCurrencies($this->id)))
            $this->warning .= $this->l('No currency set for this module') . "</br>";
        if (!Configuration::get('BITCOIN_ADDRESS_AVAILABLE'))
            $this->warning .= $this->l('No Bitcoin address left. Please add at least one Bitcoin address') . "</br>";
    }

    public function install() {
        if (!parent::install() OR !$this->installCurrency() OR !$this->installOrder() OR !$this->installDB() OR !$this->registerHook('payment') OR !$this->registerHook('paymentReturn') OR !$this->registerHook('invoice'))
            return false;
            
        Configuration::updateValue('BITCOIN_DURATION', (int) (60*60*24*3));
        return true;
    }

    function installDB() {

        Db::getInstance()->Execute("DELETE FROM `" . _DB_PREFIX_ . "module_currency` WHERE `id_module` = " . $this->id);
        Db::getInstance()->Execute("INSERT INTO `" . _DB_PREFIX_ . "module_currency`  (`id_module`, `id_currency`) VALUES ('" . $this->id . "', '" . Currency::getIdByIsoCode("BTC") . "');");
        Db::getInstance()->Execute("CREATE TABLE `" . _DB_PREFIX_ . "bitcoin_address` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `address` TEXT DEFAULT NULL, `name` TEXT DEFAULT NULL, `state` enum('available','unavailable') NOT NULL, `date_lastused` DATETIME NOT NULL, `date_added` DATETIME NOT NULL,PRIMARY KEY (`id`));");
        Db::getInstance()->Execute("CREATE TABLE `" . _DB_PREFIX_ . "bitcoin_orders`  (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `id_order` INT UNSIGNED NOT NULL, `bitcoin_address` TEXT NOT NULL, `waiting` FLOAT, `validate` FLOAT, `date_start` DATETIME NOT NULL, `date_end` DATETIME NOT NULL, `state` enum('open','close') NOT NULL DEFAULT  'open',PRIMARY KEY (`id`));");
        Db::getInstance()->Execute("CREATE TABLE `" . _DB_PREFIX_ . "bitcoin_payments`  (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `from_bitcoin_address` TEXT NOT NULL, `to_bitcoin_address` TEXT NOT NULL, `value` FLOAT, `state` enum('waiting','validate') NOT NULL, `date` DATETIME NOT NULL,PRIMARY KEY (`id`));");
        Configuration::updateValue('BITCOIN_ADDRESS_AVAILABLE', false);

        return true;
    }

    function installCurrency() {
        $btc = new Currency();
        $btc->name = "Bitcoin";
        $btc->iso_code = "BTC";
        $btc->iso_code_num = "";
        $btc->sign = "BTC";
        $btc->conversion_rate = 0.130;
        $btc->format = 2;
        $btc->decimals = true;
        $btc->blank = true;
        $btc->active = true;
        $btc->add();
        return true;
    }

    function installOrder() {
        $orderState = new OrderState();
        $orderState->name = array();
        foreach (Language::getLanguages() AS $language) {
            if (strtolower($language['iso_code']) == 'fr')
                $orderState->name[$language['id_lang']] = 'En attente du paiement par Bitcoin';
            else
                $orderState->name[$language['id_lang']] = 'Awaiting Bitcoin payment';
        }
        $orderState->color = '#add8e6';
        $orderState->send_email = true;
        $orderState->template = array();
        foreach (Language::getLanguages() AS $language) {
            if (strtolower($language['iso_code']) == 'fr')
                $orderState->template[$language['id_lang']] = 'bitcoin_waiting';
            else
                $orderState->template[$language['id_lang']] = 'bitcoin_waiting';
        }
        $orderState->hidden = false;
        $orderState->delivery = false;
        $orderState->logable = false;
        $orderState->invoice = false;
        if (!$orderState->add())
            return false;

        copy(dirname(__FILE__) . '/logo.gif', dirname(__FILE__) . '/../../img/os/' . (int) $orderState->id . '.gif');

        copy(dirname(__FILE__) . '/mail/en/bitcoin_waiting.txt', dirname(__FILE__) . '/../../mails/en/bitcoin_waiting.txt');
        copy(dirname(__FILE__) . '/mail/en/bitcoin_waiting.html', dirname(__FILE__) . '/../../mails/en/bitcoin_waiting.html');

        copy(dirname(__FILE__) . '/mail/fr/bitcoin_waiting.txt', dirname(__FILE__) . '/../../mails/fr/bitcoin_waiting.txt');
        copy(dirname(__FILE__) . '/mail/fr/bitcoin_waiting.html', dirname(__FILE__) . '/../../mails/fr/bitcoin_waiting.html');

        Configuration::updateValue('BITCOIN_ORDER_STATE_WAIT', (int) $orderState->id);
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall() OR !$this->uninstallCurrency() OR !$this->uninstallOrder() OR !$this->uninstallDB())
            return false;
        return true;
    }

    function uninstallDB() {
        Db::getInstance()->Execute("DELETE FROM `" . _DB_PREFIX_ . "module_currency` WHERE `id_module` = " . $this->id);
        Db::getInstance()->Execute('DROP TABLE  `' . _DB_PREFIX_ . 'bitcoin_address`;');
        Db::getInstance()->Execute('DROP TABLE  `' . _DB_PREFIX_ . 'bitcoin_orders`;');
        Db::getInstance()->Execute('DROP TABLE  `' . _DB_PREFIX_ . 'bitcoin_payments`;');
        Configuration::deleteByName('BITCOIN_ADDRESS_AVAILABLE');
        return true;
    }

    function uninstallCurrency() {
        $btc = new Currency(Currency::getIdByIsoCode("BTC"));
        $btc->delete();

        return true;
    }

    function uninstallOrder() {
        $orderState = new OrderState();
        $orderState->id = (int) Configuration::get('BITCOIN_ORDER_STATE_WAIT');
        $orderState->delete();
        Configuration::deleteByName('BITCOIN_ORDER_STATE_WAIT');

        return true;
    }

    public function getContent() {

     //print_r($_POST);

	//address
    if (isset($_POST['btnAddAddress'])) {
            Db::getInstance()->Execute("INSERT INTO `" . _DB_PREFIX_ . "bitcoin_address`  (`id`, `address`, `name`, `state`, `date_lastused`, `date_added`) VALUES (NULL, '" . $_POST['address'] . "', '" . $_POST['name'] . "', 'available', NOW(), NOW());");
        } 
    else if (isset($_POST['btnDelAddress'])) {
            Db::getInstance()->Execute("DELETE FROM `" . _DB_PREFIX_ . "bitcoin_address` WHERE `id` = " . $_POST['btnDelAddress'] . ";");
        } 
        
        //payment 
    else if (isset($_POST['btnAddPayment'])) {
        
        $order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders  WHERE `bitcoin_address` = "'.$_POST['to_bitcoin_address'].'" AND `date_start` <  "'. $_POST['date'] . ' ' . $_POST['time'].'" AND  `date_end` >  "'. $_POST['date'] . ' ' . $_POST['time'].'" AND  `state` =  \'open\' ');
        
        Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_orders` SET  `".$_POST['state']."` = ".($order[0][$_POST['state']]+$_POST['value'])."   WHERE `id` = " . $order[0]["id"] . ";");
        
        Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_address` SET  `date_lastused` = '". $_POST['date'] . " " . $_POST['time']."'   WHERE `address` = '".$_POST['to_bitcoin_address']."';");
        
            Db::getInstance()->Execute("INSERT INTO `" . _DB_PREFIX_ . "bitcoin_payments`  (`id`, `from_bitcoin_address`, `to_bitcoin_address`, `value`, `state`, `date`) VALUES (NULL, '" . $_POST['from_bitcoin_address'] . "', '" . $_POST['to_bitcoin_address'] . "', '" . $_POST['value'] . "', '" . $_POST['state'] . "', '" . $_POST['date'] . " " . $_POST['time'] . "');");
            
        } 
    else if (isset($_POST['btnDelPayment'])) {
        	$pay = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_payments  WHERE `id` = ' . $_POST['btnDelPayment']);
        	
             	$order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders  WHERE `bitcoin_address` = "'.$pay[0]['to_bitcoin_address'].'" AND `date_start` <  "'.$pay[0]['date'].'" AND  `date_end` >  "'.$pay[0]['date'].'" AND  `state` =  \'open\' ');

        Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_orders` SET  `".$pay[0]['state']."` = ".($order[0][$pay[0]['state']]-$pay[0]['value'])."   WHERE `id` = " . $order[0]["id"] . ";");
        
           Db::getInstance()->Execute("DELETE FROM `" . _DB_PREFIX_ . "bitcoin_payments` WHERE `id` = " . $_POST['btnDelPayment'] . ";");
        }
        // duration
    else if (isset($_POST['updDuration'])) {
            Configuration::updateValue('BITCOIN_DURATION', (int) $_POST['duration']);
        }

	//orders
	else if (isset($_POST['btnValOrder'])) {
		$order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders  WHERE `id` = ' . $_POST['btnValOrder']);
		
		$o = new Order( $order[0]['id_order']);
		$o->setCurrentState(Configuration::get('PS_OS_PAYMENT'));
		
		Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_address` SET  `state` =  'available'  WHERE `address` = '" . $order[0]['bitcoin_address'] . "';");
            	Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_orders` SET  `state` =  'close'  WHERE `id` = " . $_POST['btnValOrder'] . ";");
        }
    else if (isset($_POST['btnDelOrder'])) {
        	$order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders  WHERE `id` = ' . $_POST['btnDelOrder']);
        	
        	$o = new Order( $order[0]['id_order']);
		$o->setCurrentState(Configuration::get('PS_OS_CANCELED'));
		
		Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_address` SET  `state` =  'available'  WHERE `address` = '" . $order[0]['bitcoin_address'] . "';");
        	Db::getInstance()->Execute("UPDATE `" . _DB_PREFIX_ . "bitcoin_orders` SET  `state` =  'close'  WHERE `id` = " . $_POST['btnDelOrder'] . ";");
		//Db::getInstance()->Execute("DELETE FROM `" . _DB_PREFIX_ . "bitcoin_orders` WHERE `id` = " . $_POST['btnValOrder'] . ";");
        }
        

	global $smarty;
	
	$addrs = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_address ORDER BY  `state`');
	$orders = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders  WHERE `state` =  \'open\' ORDER BY  `date_end`');
	$payments = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_payments ORDER BY  `date` LIMIT 0 , 30');

        $smarty->assign(array(
            'name' => $this->displayName,
            'request_uri' => $_SERVER['REQUEST_URI'],
            'adresses' => $addrs,
            'orders' => $orders,
            'payments' => $payments,
            'duration' => Configuration::get('BITCOIN_DURATION'),
            'token' => Tools::getAdminTokenLite("AdminOrders"),
            'cur_date' => date('Y-m-d'),
            'cur_time' => date('H:i'),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/'
        ));
	

	return $this->display(__FILE__, 'tmpl/backend.tpl');

    }

    public function hookPayment($params) {

        if (!$this->active)
            return;
        if (!$this->_checkCurrency($params['cart']))
            return;
        global $smarty;

        $smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/'
        ));
        return $this->display(__FILE__, 'tmpl/payment-selection.tpl');
    }

    private function _checkCurrency($cart) {
        $currency_order = new Currency((int) ($cart->id_currency));
        $currencies_module = $this->getCurrency((int) $cart->id_currency);
        $currency_default = Configuration::get('PS_CURRENCY_DEFAULT');

        if (is_array($currencies_module))
            foreach ($currencies_module AS $currency_module)
                if ($currency_order->id == $currency_module['id_currency'])
                    return true;
    }

    public function showPayValidationPage($cart) {
        if (!$this->active)
            return;
        if (!$this->_checkCurrency($cart))
            Tools::redirectLink(__PS_BASE_URI__ . 'order.php');

        global $cookie, $smarty;
        $smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/'
        ));

        return $this->display(__FILE__, 'tmpl/payment-validation.tpl');
    }

    public function hookPaymentReturn($params) {
        if (!$this->active)
            return;

        global $smarty;

        $state = $params['objOrder']->getCurrentState();
        if ($state == Configuration::get('BITCOIN_ORDER_STATE_WAIT') OR $state == _PS_OS_OUTOFSTOCK_) {
            $b_order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders WHERE `id_order` = ' . $params['objOrder']->id . '  LIMIT 1');
            $smarty->assign(array(
                'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false),
                'id_order' => $params['objOrder']->id,
                'status' => 'waiting',
                'From' => $b_order[0]['date_start'],
                'To' => $b_order[0]['date_end'],
                'BitcoinWaiting' => $b_order[0]['waiting'],
                'BitcoinValidate' => $b_order[0]['validate'],
                'BitcoinAddress' => $b_order[0]['bitcoin_address']
            ));
        }
        else if ($state == Configuration::get('PS_OS_PAYMENT') )
            $smarty->assign('status', 'validate'); 
        else
            $smarty->assign('status', 'failed');

        return $this->display(__FILE__, 'tmpl/payment-return.tpl');
    }

    function hookInvoice($params) {
        global $smarty;
      //  print_r($params);
        $b_order = Db::getInstance()->ExecuteS('SELECT * FROM ' . _DB_PREFIX_ . 'bitcoin_orders WHERE `id_order` = ' . $params['id_order'] . '  LIMIT 1');
        $smarty->assign(array(
            'waiting' => $b_order[0]['waiting'],
            'validate' => $b_order[0]['validate'],
            'address' => $b_order[0]['bitcoin_address'],
            'state' => $b_order[0]['state']
        ));
     
     return $this->display(__FILE__, 'tmpl/invoice.tpl');
    }

}

?>
