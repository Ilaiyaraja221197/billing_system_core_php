<?php
require 'vendor/autoload.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['action'] ) ) {
	$response   = [];
	$controller = new \App\Controllers\PurchaseController();
	switch ( $_POST['action'] ) {
		case 'getInitialData':
			$response = $controller->getInitialData();
			break;
		case 'getCategoryData':
			$category = $_POST['category'];
			$response = $controller->loadItemCode( $category );
			break;
		case 'getItemCodeData':
			$itemCode = $_POST['item_code'];
			$response = $controller->loadDescription( $itemCode );
			break;
		case 'getUnitsData':
			$description = $_POST['description'];
			$response = $controller->loadUnits( $description );
			break;
		case 'getVatData':
			$vat = $_POST['vat_code'];
			$response = $controller->loadVat( $vat );
			break;
		case 'saveData':
			$response = $controller->savePurchase($_POST);
			break;

	}
	echo json_encode( $response );
	exit();
}
