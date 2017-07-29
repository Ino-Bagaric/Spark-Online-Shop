<?php
include(__DIR__ . '/../classes/DB.php');
require_once(__DIR__ . "/../vendor/autoload.php");


$db = DB::getConnection();
$user = -1;

function checkAuth() {
	global $user;

	$token = apache_request_headers()['Authorization'];
	try {
		$decode = Firebase\JWT\JWT::decode(
			$token, 
			'SNSNYR3Mzty3yT5A4OqbL1QW2RlQxsodOCBBwiZNIYBPrbo58lkVPv2Aqh9O16cg', 
			array('HS256')
		);

		$user = get_object_vars($decode)['user'];
	} catch (Exception $e) {
		//return json_encode($e->getMessage());
		return false;
	}
	return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	global $user, $db;

	if (!checkAuth()) {
		echo json_encode([]);
		return;
	}

	parse_str(file_get_contents('php://input'), $_PUT);

	$data = array();
	$item = $_PUT['item'];
	$stock = $_PUT['stock'];

	try {
		$stmt = $db->prepare("UPDATE Products SET `stock` = ? WHERE id = ?");
		$stmt->bindParam(1, $stock, PDO::PARAM_INT);
		$stmt->bindParam(2, $item, PDO::PARAM_INT);
		$stmt->execute();
		$data[] = true;
	} catch (Exception $e) {
		$data[] = false;
	}
	echo json_encode($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$_DELETE = array();
	parse_str(file_get_contents('php://input'), $_DELETE);
	echo json_encode(array('user' => 132, 'test' => 'delete'));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	global $user, $db;

	if (!checkAuth()) {
		echo json_encode([]);
		return;
	}
	
	$data = array();
	$item = $_GET['item'];
	$page = $_GET['page'];

	if ($page === 'shop') {
		shop:
		try {
			if ($item == -1) { // Get all items
				$results = $db->prepare("SELECT * FROM Products");
				$results->execute();
				$data = $results->fetchAll(PDO::FETCH_COLUMN);
			} else {
				$results = $db->prepare("SELECT * FROM Products WHERE id = ?");
				$results->bindParam(1, $item, PDO::PARAM_INT);
				$results->execute();
				$data = $results->fetch(PDO::FETCH_COLUMN);
			}		
		} catch (Exception $e) {
			$data = array();
		}
	} else if ($page === 'history') {
		try {
			$results = $db->prepare("SELECT product_id FROM ProductOwners WHERE user_id = ?");
			$results->bindParam(1, $user, PDO::PARAM_INT);
			$results->execute();
			$data = $results->fetchAll(PDO::FETCH_COLUMN);
		} catch (Exception $e) {
			$data[] = $e->getMessage();
		}
	} else if ($page === 'cart') {
		try {
			$results = $db->prepare("SELECT product_id FROM Cart WHERE user_id = ?");
			$results->bindParam(1, $user, PDO::PARAM_INT);
			$results->execute();
			$data = $results->fetchAll(PDO::FETCH_COLUMN);
		} catch (Exception $e) {
			$data[] = $e->getMessage();
		}
	} else {
		goto shop;
	}

	echo json_encode($data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	global $user, $db;

	if (!checkAuth()) {
		echo json_encode([]);
		return;
	}

	parse_str(file_get_contents('php://input'), $_POST);
	
	$data = array();
	$item = $_POST['item'];
	$page = $_POST['page'];

	try {
		$stmt = $db->prepare("INSERT INTO Cart (product_id, user_id) VALUES (?, ?)");
		$stmt->bindValue(1, $item, PDO::PARAM_INT);
		$stmt->bindValue(2, $user, PDO::PARAM_INT);
		$stmt->execute();
		$data[] = true;
	} catch (Exception $e) {
		$data[] = false;
	}
	echo json_encode($data);
}

