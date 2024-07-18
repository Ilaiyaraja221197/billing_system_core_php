<?php

namespace App\Models;

use App\Database;
use mysqli;

class Purchase {
	private $mysqli;

	public function __construct() {
		$db           = new Database();
		$this->mysqli = $db->connect();
	}

	public function getCategoryList() {
		$stmt = $this->mysqli->prepare( "SELECT DISTINCT cat  as category FROM ims_itemcodes" );
		$stmt->execute();
		$result     = $stmt->get_result();
		$categories = array();
		while ( $row = $result->fetch_assoc() ) {
			$categories[] = $row['category'];
		}

		return $categories;
	}

	public function getItemCodeList() {
		$stmt = $this->mysqli->prepare( "SELECT DISTINCT code  as item_code FROM ims_itemcodes" );
		$stmt->execute();
		$result     = $stmt->get_result();
		$categories = array();
		while ( $row = $result->fetch_assoc() ) {
			$categories[] = $row['item_code'];
		}

		return $categories;
	}

	public function getItemDescriptionList() {
		$stmt = $this->mysqli->prepare( "SELECT DISTINCT description  as item_code FROM ims_itemcodes" );
		$stmt->execute();
		$result     = $stmt->get_result();
		$categories = array();
		while ( $row = $result->fetch_assoc() ) {
			$categories[] = $row['item_code'];
		}

		return $categories;
	}
	public function getVatCodes() {
		$stmt = $this->mysqli->prepare( "SELECT * FROM vat" );
		$stmt->execute();
		$result     = $stmt->get_result();

		return $result->fetch_all( MYSQLI_ASSOC );

	}

	public function getItemCodesByCategory( $category ) {
		$stmt = $this->mysqli->prepare( "SELECT code FROM ims_itemcodes WHERE cat = ?" );
		$stmt->bind_param( "s", $category );
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_all( MYSQLI_ASSOC );
	}



	public function getDescriptionByItemCode( $itemCode ) {
		$stmt = $this->mysqli->prepare( "SELECT description, sunits FROM ims_itemcodes WHERE code = ?" );
		$stmt->bind_param( "s", $itemCode );
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();
	}

	public function getUnitsByDescription( $description ) {
		$stmt = $this->mysqli->prepare( "SELECT sunits FROM ims_itemcodes WHERE description = ?" );
		$stmt->bind_param( "s", $description );
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();
	}

	public function getVatPercentage( $vatCode ) {
		$stmt = $this->mysqli->prepare( "SELECT vatper FROM vat WHERE code = ?" );
		$stmt->bind_param( "s", $vatCode );
		$stmt->execute();
		$result = $stmt->get_result();

		return $result->fetch_assoc();
	}

	public function savePurchase( $data ) {

		$stmt = $this->mysqli->prepare("
            INSERT INTO purchases (items, basic_amount, discount_type, discount, total_price) 
            VALUES (?, ?, ?, ?, ?)
        ");
		$stmt->bind_param(
			'sdsds',
			$data['items'],
			$data['basic_amount'],
			$data['discount_type'],
			$data['discount'],
			$data['total_price']
		);
		$stmt->execute();
		$stmt->close();

	}
}
