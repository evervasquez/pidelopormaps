<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'path/to/Google_Client.php';

$client = new Google_Client();
$client->setClientId('386356220154.apps.googleusercontent.com');
$client->setClientSecret('wDbYvxKgFNIcA4iK7uPidzhE');
$client->setRedirectUri('https://localhost/ubicaciones/principal.html');
$client->setDeveloperKey('insert_your_developer_key');
