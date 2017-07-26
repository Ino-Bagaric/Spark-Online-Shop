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