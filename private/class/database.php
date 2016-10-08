<?php	
// database class
class Database
{
	private $hostname = 'localhost';
	private $database = 'villazo';
	private $username = 'root';
	private $password = '';
	//private $encryptKey = 'dAg8eL2h';
	private $encryptKey = 'X8J6FBbs';
	
	// get key
	public function getEncryptKey() { return $this->encryptKey; }
				
	// connect to the database
	public function connect()
	{
		$db = new PDO("mysql:host=$this->hostname;dbname=$this->database;charset=utf8", $this->username, $this->password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		return $db;
	}
	
	// insert query
	public function queryInsert($query, $argArray = '')
	{
		try
		{
		    $db = $this->connect();
			$stmt = $db->prepare($query);
			if ($argArray)
			{
				foreach ($argArray as $key=>$value)
				{
					$stmt->bindValue($key + 1, $value);
				}
			}
			
			if ($stmt->execute()) return $db->lastInsertId();
			else return 0;
		}
		catch(PDOException $exception)
		{
		    $this->manageDBError($exception->getMessage());
		}
	}
	
	// update query
	public function queryUpdate($query, $argArray = '')
	{
		try
		{
			$db = $this->connect();
			$stmt = $db->prepare($query);
			if ($argArray)
			{
				foreach ($argArray as $key=>$value)
				{
					$stmt->bindValue($key + 1, $value);
				}
			}
			
			if ($stmt->execute()) return 1;
			else return 0;
		}
		catch(PDOException $exception)
		{
		    $this->manageDBError($exception->getMessage());
		}
	}
	
	// select query
	public function querySelect($query, $argArray = '')
	{
		try
		{
			$db = $this->connect();
			$stmt = $db->prepare($query);
			if ($argArray)
			{
				foreach ($argArray as $key=>$value)
				{
					$stmt->bindValue($key + 1, $value);
				}
			}
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $exception)
		{
		    $this->manageDBError($exception->getMessage());
		}
	}
	
	// query result
	public function queryResult($query)
	{
		return $query->fetch(PDO::FETCH_ASSOC);
	}
	
	// query count
	public function queryCount($query)
	{
		return $query->rowCount();
	}
	
	// manage database error
	public function manageDBError($error)
	{
		//echo '<p style="text-align:center; font-weight:bold;">An error occured and we have been informed about it - please come back later.</p>';		
		mail('shyamal@consumer-sketch.com', 'Database Error: '.$_SERVER['HTTP_HOST'], $error.' @ '.$_SERVER['REQUEST_URI'], "From: olivier@maddev.com\nContent-Type: text/html; charset=iso-8859-1");
	}
}
?>