<?php
class Alert
{
	public static function hasError($error) 
	{
		return (bool)count($error);
	}
	public static function error($error)
	{
		?> <div class="alert error"><?php echo (is_array($error)) ? implode('<br>', $error) : $error; ?></div> <?php
	}
	public static function success($message)
	{
		?> <div class="alert success"><?php echo $message; ?></div> <?php
	}
	public static function warning($message)
	{
		?> <div class="alert warning"><?php echo $message; ?></div> <?php
	}
	public static function info($message)
	{
		?> <div class="alert info"><?php echo $message; ?></div> <?php
	}
}