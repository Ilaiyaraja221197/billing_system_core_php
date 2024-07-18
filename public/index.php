<?php
ini_set('display_errors', 1);
require '../vendor/autoload.php';

use App\Database;
use App\Controllers\PurchaseController;

$db = new Database();
$mysqli = $db->connect();

//$purchase_controller = new PurchaseController();
//echo "<pre>";
//print_r($categories);
//echo "</pre>";

include 'views/purchase_form.php';
