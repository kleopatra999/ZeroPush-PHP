ZeroPush-PHP
============

ZeroPush is a simple service for sending Apple Push Notifications. This library wraps the API requests for use in PHP

Example Usage
===

``php
<?php

require('zero_push.php');

$client = new ZeroPush("your-auth-token");
$tokens = array("64-digit-device-token");
$response = $client->notify(array("device_tokens" => $tokens, "title" => "Hello, World", "body" => "From ZeroPush"));


```
