<?php
$title = 'Home';
require_once(__DIR__ . '/core/init.php');
use Firebase\JWT\JWT;

$user = new User();
$data = $user->getData();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

$key = base64_encode(mcrypt_create_iv(32));
$token = array();
$token['user'] = $user->getUserId();
$jwt = JWT::encode($token, $key);

$api = new API($jwt, $key);

?>

<body>
	<div class="wrapper">
		<p>Hello <?php echo $data['name'] . ' | Money: ' . $data['money']; ?></p>
	</div>
</body>