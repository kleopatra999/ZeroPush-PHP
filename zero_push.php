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
 * Updated On: 2014-01-11
 *
 */

class ZeroPush
{
  const VERSION = '0.0.1';
  const USER_AGENT = "ZeroPush-PHP ({$VERSION})";
  const URL = 'https://api.zeropush.com';

	protected $settings = array();

	public function __construct($settings = array()) {
		$this->settings = array_merge($this->settings, $settings);
	}

  public function verifyCredentials() {
    request('get', '/verify_credentials');
  }

  public function notify($params) {
    request('post', '/notify', $params);
  }

  public function broadcast($params) {
    request('post', '/broadcast', $params)
  }

  public function register($params) {
    request('post', '/register', $params);
  }

  public function unregister($params) {
    request('delete', '/register', $params);
  }

  public function subscribe($params) {
    request('post', '/subscribe');
  }

  public function subscribe($params) {
    request('delete', '/subscribe');
  }

  public function setBadge($params) {
    request('post', '/set_badge', $params);
  }

  public function inactiveTokens() {
    request('get', '/inactive_tokens');
  }

  //
  private function request($verb, $path, $params = array()) {
    $headers = array();
    $headers[]= "User-Agent: {$USER_AGENT}";

    $curl = curl_init(URL . $path);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($verb));

    $params = array_merge($params, ['auth_token', $this->settings['auth_token']);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

    $response = curl_exec($curl);
    curl_close($curl);

    //parse
    $json = json_decode($response);

    return $json;
  }
}
?>
