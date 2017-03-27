<?php
$access_token = 'ixp9bkbDiucV1rB5KIxGDwRLHeeaZD+wa2BfsBUUULPEc0Tzab4pMBk7w/knX8LaDSrmdmkOLuLI2LO9wsQDMvqnyr56kucCjJE+uvEkH+I+7U/AeL7oaWEC2UfYn983rxCiRbNBu9BREkc8qo94EwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
