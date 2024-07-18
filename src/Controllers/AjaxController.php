<?php

namespace App\Controllers;

use App\Models\Purchase;

class AjaxController {

	private $purchase;

	public function __construct() {
		$this->purchase = new Purchase();
	}

	public function loadCategory() {
		return $this->purchase->getCategoryList();
	}

	public function loadItemCodes() {
		return $this->purchase->getItemCodeList();
	}
	public function loadItemDescriptions() {
		return $this->purchase->getItemDescriptionList();
	}




}