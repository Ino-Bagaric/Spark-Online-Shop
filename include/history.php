<?php

$products = $api->getProduct(-1, 'history');

if (isset($_GET['option'])) {
	$option = $_GET['option'];

	if ($option === 'cancel') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			if ($products[$id]['time'] - time() > 0) {
				Alert::Success('Product canceled');
			} else {
				Alert::Error('It\'s too late to cancel');
			}

			$api->cancelPurchase($products[$id]['product_id']);
		}
	}
} else {
	$i = 0;
	foreach ($products as $product) {
		$item = $api->getProductData($product['product_id']);
		echo '<h2>' . $item['title'] . '</h2>';
		echo '<p>' . $item['description'] . '</p>';
		echo '<p>Price: ' . $item['price'] . '</p>';
		echo '<p><b>Stock: ' . $item['stock'] . '</b></p>';

		$time = $product['time'] - time();
		if ($time > 0) {
			echo '<a href="?page=history&option=cancel&id=' . $i . '">Cancel (Time left: ' . $time . ')</a>';
		}
		$i++;

		echo '<hr><br>';
	}
}



