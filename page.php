<?php
$title = 'Home';
require_once(__DIR__ . '/core/init.php');

$user = new User();
$data = $user->getData();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

?>
<body>
	<div class="wrapper">
		<p>Hello <?php echo $data['name'] . ' | Money: ' . $data['money']; ?></p>
	</div>
</body>

<?php
$token = $user->generateToken();
$api = new API($token);


if (isset($_GET['page'])) {
	$page = $_GET['page'];

	switch ($page) {
		case 'shop':
			include('include/shop.php');
			break;
		case 'history':
			include('include/history.php');
			break;
		case 'cart':
			include('include/cart.php');
			break;
	}
}

if (isset($_GET['option'])) {
	$option = $_GET['option'];

	if ($option === 'cart') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			if ($api->addToCart($id)) {
				Alert::Success('Product added in cart');
			} else {
				Alert::Error('You can\'t add this product in cart');
			}
		}
	}
}
