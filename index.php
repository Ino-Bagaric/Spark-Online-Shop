<?php
require_once(__DIR__ . '/core/init.php');

$db = DB::getConnection();
$user = new User();

if ($user->isLoggedIn()) {
	Redirect::to('page.php');
}
?>

<body>
	<?php Alert::warning("You are not logged in, please login to access the page"); ?>

	<a href="login.php">Login</a><br>
	<a href="register.php">Register</a>
</body>
