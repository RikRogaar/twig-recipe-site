<?php

require_once 'vendor/autoload.php';

use RedBeanPHP\R as R;

$dbhost = "localhost";
$dbname = "your-fullstack-framework";
$dbuser = "bit_academy";
$dbpass = "bit_academy";

R::setup("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);