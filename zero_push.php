<?php

/*
 * ZeroPush-PHP - php library for the ZeroPush API
 *
 * Documentation: https://zeropush.com/documentation/api_reference
 * License: MIT
 *
 * Authors:
 *   Stefan Nathev <stefan@zeropush.com>
 *   Adam V. Duke  <adam@zeropush.com>
 *
 * Created On: 2014-01-11
 * Updated On: 2014-06-30
 *
 */

class ZeroPush
{
  const VERSION = '1.0.0';
  const USER_AGENT = "ZeroPush-PHP ({self::VERSION})";
  const URL = 'https://api.zeropush.com';

  protected $settings = array();

  public function __construct($auth_token) {
    $settings = array('auth_token' => $auth_token);
    $this->settings = array_merge($this->settings, $settings);
  }

  public function verifyCredentials() {
    return $this->request('get', '/verify_credentials');
  }

  public function notify($params) {
    return $this->request('post', '/notify', $params);
  }

  public function broadcast($params) {
    return $this->request('post', '/broadcast', $params);
  }

  public function register($params) {
    return $this->request('post', '/register', $params);
  }

  public function unregister($params) {
    return $this->request('delete', '/register', $params);
  }

  public function subscribe($params) {
    return $this->request('post', '/subscribe');
  }

  public function unsubscribe($params) {
    return $this->request('delete', '/subscribe');
  }

  public function setBadge($params) {
    return $this->request('post', '/set_badge', $params);
  }

  public function inactiveTokens() {
    return $this->request('get', '/inactive_tokens');
  }

  //
  private function request($verb, $path, $params = array()) {
    $headers = array();
    $headers[]= "User-Agent: {self::USER_AGENT}";

    $curl = curl_init(self::URL . $path);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($verb));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $params = array_merge($params, $this->settings);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query_with_array($params));

    $response = curl_exec($curl);

    if($response == null) {
      error_log(curl_error($curl));
    }

    curl_close($curl);

    //parse
    $json = json_decode($response, true);

    return $json;
  }
}

function http_build_query_with_array($a,$b='',$c=0)
{
  if (!is_array($a)) return false;
  foreach ((array)$a as $k=>$v)
  {
    if ($c)
    {
      if( is_numeric($k) )
        $k=$b."[]";
      else
        $k=$b."[$k]";
    }
    else
    {   if (is_int($k))
    $k=$b.$k;
    }

    if (is_array($v)||is_object($v))
    {
      $r[]=http_build_query_with_array($v,$k,1);
      continue;
    }
    $r[]=urlencode($k)."=".urlencode($v);
  }
  return implode("&",$r);
}
?>
