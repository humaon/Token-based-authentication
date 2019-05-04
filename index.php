<?php
ini_set('display_errors','on');
require __DIR__ . '/vendor/autoload.php';

use App\Classes\Api;
use App\Classes\DB;
$connection =new DB();
//echo $connection->connect();


$api=new Api();
$api->generateToken();


