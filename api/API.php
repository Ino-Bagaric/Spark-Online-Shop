<?php
class API 
{
	private $token;
	private $api_request_url;
	private $db;

	public function __construct($token)
	{
		$this->token = $token;
		$this->db = DB::getConnection();;
		$this->api_request_url = "$_SERVER[HTTP_HOST]/Spark-Online-Shop/api/index.php";
	}

	public function getProduct($id = -1, $page = 'shop')
	{
		$method_name = 'GET';

		$api_request_parameters = array(
			'item' => $id,
			'page' => $page
		);
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		 
		$this->api_request_url .= '?' . http_build_query($api_request_parameters);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Authorization: ' . $this->token
		));
		curl_setopt($ch, CURLOPT_URL, $this->api_request_url);

		$api_response = curl_exec($ch);
		$api_response_info = curl_getinfo($ch);
		 
		curl_close($ch);
		 
		$api_response_header = trim(substr($api_response, 0, $api_response_info['header_size']));
		$api_response_body = substr($api_response, $api_response_info['header_size']);

		$data = array();
		$products = json_decode($api_response_header, true);
		
		if (!$products) return [];
		if ($id != -1) return $this->getProductData($products);

		foreach ($products as $product) {
			$data[] = $this->getProductData($product);
		}

		return $data;
	}

	private function getProductData($id)
	{
		$data = array();

		try {
			$results = $this->db->prepare("SELECT * FROM Products WHERE id = ?");
			$results->bindParam(1, $id, PDO::PARAM_INT);
			$results->execute();
			$data = $results->fetch(PDO::FETCH_ASSOC);		
		} catch (Exception $e) {
			$data = array();
		}
		
		return $data;
	}

	private function updateProduct($id, $stock)
	{
		$api_request_parameters = array(
			'item' => $id,
			'stock' => $stock
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
		 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Authorization: ' . $this->token
		));
		curl_setopt($ch, CURLOPT_URL, $this->api_request_url);

		$api_response = curl_exec($ch);
		$api_response_info = curl_getinfo($ch);
		
		curl_close($ch);
		
		$api_response_header = trim(substr($api_response, 0, $api_response_info['header_size']));
		$api_response_body = substr($api_response, $api_response_info['header_size']);

		$data = json_decode($api_response_header, true);
		
		return (bool)$data[0];
	}

	public function purchase()
	{
		// TODO
	}

	public function cancelPurchase()
	{
		// TODO
	}

	public function addToCart($id, $page = 'cart') 
	{
		$productData = $this->getProductData($id);
		$stock = $productData['stock'];
		if ($stock <= 0) return false;

		// If used owns this item already
		$cartData = $this->getProduct(-1, 'cart');
		foreach ($cartData as $item) {
			if ($item['id'] == $id) {
				return false;
			}
		}

		$api_request_parameters = array(
			'item' => $id,
			'page' => $page
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
		 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Authorization: ' . $this->token
		));
		curl_setopt($ch, CURLOPT_URL, $this->api_request_url);

		$api_response = curl_exec($ch);
		$api_response_info = curl_getinfo($ch);
		
		curl_close($ch);
		
		$api_response_header = trim(substr($api_response, 0, $api_response_info['header_size']));
		$api_response_body = substr($api_response, $api_response_info['header_size']);

		$data = json_decode($api_response_header, true);

		$this->updateProduct($id, $stock - 1);
		
		return (bool)$data[0];
	}
}


