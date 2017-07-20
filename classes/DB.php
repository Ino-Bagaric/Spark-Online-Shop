<?php
class DB
{
	private static $connection;
	private static $instance;

	private function __construct()
	{
		try {
			self::$connection = new PDO("sqlite:" . __DIR__ . "/database.db");
  			self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$this->initTables();
		} catch (Exception $e) {
			echo "Unable to connect: <br>";
			echo $e->getMessage();
			exit;
		}
	}

	private static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new DB();
		}
		return self::$instance;
	}

	public static function getConnection()
	{
		self::getInstance();
		return self::$connection;
	}

	private function initTables()
	{
		$query = '';

		// Users
		$query = 'CREATE TABLE IF NOT EXISTS Users ';
		$query .= '(`id` INTEGER PRIMARY KEY AUTOINCREMENT, ';
		$query .= '`username` TEXT, ';
		$query .= '`name` TEXT, ';
		$query .= '`lastname` TEXT, ';
		$query .= '`password` TEXT, ';
		$query .= '`email` TEXT, ';
		$query .= '`permission` INTEGER, ';
		$query .= '`money` INTEGER)';
		self::$connection->exec($query); 

		// Default user
		$query = "INSERT OR IGNORE INTO Users (`id`, `username`, `name`, `lastname`, `password`, `email`, `permission`, `money`) VALUES ('1', 'admin', 'Administrator', '', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'admin@host.com', 2, 9999)";
		self::$connection->exec($query);

		// Permissions
		$query = 'CREATE TABLE IF NOT EXISTS Permissions ';
		$query .= '(`permission_id` INTEGER UNIQUE, `permission_name` TEXT)';
		self::$connection->exec($query); 

		$permissions = array(
			[1, 'User'],
			[2, 'Administrator']
		);

		foreach ($permissions as $permission) {
			$query = "INSERT OR IGNORE INTO Permissions (`permission_id`, `permission_name`) VALUES ({$permission[0]}, '{$permission[1]}')";
			self::$connection->exec($query);
		}

		// Products
		$query = 'CREATE TABLE IF NOT EXISTS Products ';
		$query .= '(`id` INTEGER PRIMARY KEY AUTOINCREMENT, ';
		$query .= '`title` TEXT, ';
		$query .= '`description` TEXT, ';
		$query .= '`price` INTEGER, ';
		$query .= '`stock` INTEGER)';
		self::$connection->exec($query); 

		// Products -> Owners
		$query = 'CREATE TABLE IF NOT EXISTS ProductOwners ';
		$query .= '(`product_id` INTEGER, ';
		$query .= '`user_id` INTEGER)';
		self::$connection->exec($query); 
	}
}