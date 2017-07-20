<?php
session_start();

spl_autoload_register(function($class) {
	require_once('classes/' . $class . '.php');
});

// Page title
if (!isset($title)) {
	$title = 'Online Shop';
}
?>

<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
</html>