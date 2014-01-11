#!/usr/bin/env php
<?php

require('zero_push.php');

$client = new ZeroPush('auth-token');
$response = $client->verifyCredentials();
echo var_dump( $response );

if( $response['message'] == 'authenticated') {
  print("passed\n");
}
else {
  die("failed\n");
}

?>
