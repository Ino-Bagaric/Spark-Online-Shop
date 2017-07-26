<?php
session_start();

const PERMISSION_USER = 1;
const PERMISSION_ADMINISTRATOR = 2;

require_once(__DIR__ . '/../vendor/autoload.php');

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