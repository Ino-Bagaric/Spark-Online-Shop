<?php

if (isset($_GET['option'])) {
	$option = $_GET['option'];

	if ($option === 'buy') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			if ($api->purchase($id)) {
				Alert::Success('Product bought, you still can cancel it in history');
			} else {
				Alert::Error('You can\'t add this product in bought items');
			}
		}
	}
} else {
	$products = $api->getProduct(-1, 'cart');

	foreach ($products as $product) {	
		echo '<h2>' . $product['title'] . '</h2>';
		echo '<p>' . $product['description'] . '</p>';
		echo '<p>Price: ' . $product['price'] . '</p>';
		echo '<p><b>Stock: ' . $product['stock'] . '</b></p>';
		echo '<a href="?page=cart&option=buy&id=' . $product['id'] . '">Buy</a>';
	}
}

