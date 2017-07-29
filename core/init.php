<?php
session_start();

const PERMISSION_USER = 1;
const PERMISSION_ADMINISTRATOR = 2;

require_once(__DIR__ . '/../vendor/autoload.php');

// Page title
if (!isset($title)) {
	$title = 'Online Shop';
}

$user = new User();
?>

<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<div class="nav">
	<a href="?page=shop">Shop</a>
	<a href="?page=history">History</a>
	<?php if ($user->isLoggedIn()) { ?>
		<a href="?page=cart">Cart (5)</a>
	<?php } ?>
	<a href="#">test</a>
</div>

</html>

