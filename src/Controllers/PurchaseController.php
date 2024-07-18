<?php

namespace App\Controllers;

use App\Models\Purchase;

class PurchaseController {
	private $purchase;

	public function __construct() {
		$this->purchase = new Purchase();
	}

	public function getInitialData() {

		return array(
				'categories' => $this->purchase->getCategoryList(),
				'item_codes' => $this->purchase->getItemCodeList(),
				'descriptions' => $this->purchase->getItemDescriptionList(),
				'vat_codes' => $this->purchase->getVatCodes(),
				'invoice_no' => 1
		);
	}

	public function loadItemCode( $category ) {
		return $this->purchase->getItemCodesByCategory( $category );
	}

	public function loadDescription( $itemCode ) {
		return $this->purchase->getDescriptionByItemCode( $itemCode );
	}

	public function loadUnits( $description ) {
		return $this->purchase->getUnitsByDescription( $description );
	}

	public function loadVat( $vatCode ) {
		return $this->purchase->getVatPercentage( $vatCode );
	}

	public function savePurchase( $data ) {
		if (empty($data['items']) || !is_array($data['items'])) {
			echo json_encode(['status' => 'error', 'message' => 'No valid items provided.']);
			return;
		}

		$purchaseData = [
			'items' => json_encode($data['items']), // Convert items array to JSON string
			'discount' => $data['discount'],
			'discount_type' => $data['discount_type'],
			'basic_amount' => $data['basic_amount'],
			'total_price' => $data['total_price'],
		];

		$this->purchase->savePurchase($purchaseData);

		echo json_encode(['status' => 'success', 'message' => 'Form data saved successfully.']);

	}
}
