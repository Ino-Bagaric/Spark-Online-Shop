<?php
class API 
{
	private $key;
	private $token;
	private $userid;

	public function __construct($token, $key)
	{
		$decoded = Firebase\JWT\JWT::decode($token, $key, array('HS256'));
		$this->userid = get_object_vars($decoded)['user'];
	}

	public function getAllProducts()
	{
		// TODO
	}

	public function putProductInCart()
	{
		// TODO
	}

	public function purchase()
	{
		// TODO
	}

	public function cancelPurchase()
	{
		// TODO
	}

	public function getMyProducts()
	{
		// TODO
	}
}


