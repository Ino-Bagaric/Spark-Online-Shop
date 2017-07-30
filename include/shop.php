<?php
$products = $api->getProduct();

foreach ($products as $product) {
	echo '<h2>' . $product['title'] . '</h2>';
	echo '<p>' . $product['description'] . '</p>';
	echo '<p>Price: ' . $product['price'] . '</p>';
	echo '<p><b>Stock: ' . $product['stock'] . '</b></p>';

	if ($product['stock'] > 0) {
		echo '<a href="?page=shop&option=cart&id=' . $product['id'] . '">Add to cart</a>';
	}
	
	echo '<hr><br>';
}
