<?php
namespace app\extensions\action;

class OAuthConsumer extends \lithium\action\Controller {
  public $key;
  public $secret;
  // JR: bugfix
  public $callback_url;

  function __construct($key, $secret, $callback_url=NULL) {
    $this->key = $key;
    $this->secret = $secret;
    $this->callback_url = $callback_url;
  }

  function __toString() {
    return "OAuthConsumer[key=$this->key,secret=$this->secret]";
  }
}

?>