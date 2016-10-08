<?php
// user class
class User
{
	// UPDATE USER SET USER_PASSWORD = AES_ENCRYPT('admin', '1WUj9EJN') WHERE USER_EMAIL = 'olivier@maddev.com'
	// INSERT INTO USER (USER_EMAIL, USER_PASSWORD) VALUES ('olivier@maddev.com', AES_ENCRYPT('admin', '1WUj9EJN'))
	private $userId;
	private $userGroupId;
	private $firstName;
	private $lastName;
	private $email;
	
	private $userGroupAdminArray = array(1, 2, 4);
	private $userGroupOwnerArray = array(3);
		
	// set first name
	public function setFirstName($firstName) { $this->firstName = $firstName; }
		
	// set last name
	public function setLastName($lastName) { $this->lastName = $lastName; }
		
	// set email
	public function setEmail($email) { $this->email = $email; }
	
	// get user id
	public function getUserId() { return $this->userId; }
	
	// get usergroup id
	public function getUserGroupId() { return $this->userGroupId; }
	
	// get first name
	public function getFirstName() { return $this->firstName; }
	
	// get last name
	public function getLastName() { return $this->lastName; }
	
	// get email
	public function getEmail() { return $this->email; }
	
	// login
	public function login($email = '', $password = '', $remember = '')
	{
		if ($this->userId)
		{
			$rs_user = $_SESSION['DB']->querySelect('SELECT USER_ID, USERGROUP_ID, USER_EMAIL, USER_FIRSTNAME, USER_LASTNAME FROM USER WHERE USER_ID = ? LIMIT 1', array($this->userId));
			$response = 'redirect';
		}
		else if (isset($_COOKIE['USER_TOKEN']))
		{
			$rs_user = $_SESSION['DB']->querySelect('SELECT USER_ID, USERGROUP_ID, USER_EMAIL, USER_FIRSTNAME, USER_LASTNAME FROM USER WHERE USER_TOKEN = AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\') LIMIT 1', array($_COOKIE['USER_TOKEN']));
			$response = 'redirect';
		}
		else
		{
			$rs_user = $_SESSION['DB']->querySelect('SELECT USER_ID, USERGROUP_ID, USER_EMAIL, USER_FIRSTNAME, USER_LASTNAME, AES_DECRYPT(USER_TOKEN, \''.$_SESSION['DB']->getEncryptKey().'\') AS USER_TOKEN FROM USER WHERE USER_EMAIL = ? AND USER_PASSWORD = AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\') LIMIT 1', array($email, $password));
			$response = 'return';
		}
		
		if ($_SESSION['DB']->queryCount($rs_user))
		{	 
			$row_rs_user = $_SESSION['DB']->queryResult($rs_user);
			$this->userId = $row_rs_user['USER_ID'];
			$this->userGroupId = $row_rs_user['USERGROUP_ID'];
			$this->firstName = $row_rs_user['USER_FIRSTNAME'];
			$this->lastName = $row_rs_user['USER_LASTNAME'];
			$this->email = $row_rs_user['USER_EMAIL'];
			//$_SESSION['DB']->queryInsert('INSERT INTO USER_LOG (USER_LOG_IP, USER_ID) VALUES (?, ?)', array($_SERVER['REMOTE_ADDR'], $this->userId));
				
			if ($remember)
			{
				$userToken = hash('sha256', $this->userId.uniqid());
				
				if ($_SESSION['DB']->queryUpdate('UPDATE USER SET USER_TOKEN = AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\') WHERE USER_ID = ? LIMIT 1', array($userToken, $this->userId))) setcookie('USER_TOKEN', $userToken, time()+60*60*24*30, '/');
			}
									
			// redirect
			if (in_array($this->userGroupId, $this->userGroupAdminArray)) $redirectUrl =  '/reservations/';
			else if (in_array($this->userGroupId, $this->userGroupOwnerArray)) $redirectUrl = '/reservations/';
			else
			{
				$this->logout();
				$redirectUrl = '/401/';
			}
			
			if ($response == 'redirect') header('Location: '.(basename($_SERVER['PHP_SELF'])=='login.php'?$redirectUrl:$_SERVER['REQUEST_URI']));
			else if ($response == 'return') return $redirectUrl;
		}
		else
		{
			setcookie('USER_TOKEN', NULL, time()-3600, '/');
			return '';
		}
	}
	
	// register
	public function register($userGroupId, $email, $password, $firstName, $lastName)
	{
		if ($_SESSION['DB']->queryInsert('INSERT INTO USER (USERGROUP_ID, USER_EMAIL, USER_PASSWORD, USER_FIRSTNAME, USER_LASTNAME) VALUES (?, ?, AES_ENCRYPT(?, \''.$_SESSION['DB']->getEncryptKey().'\'), ?, ?)', array($userGroupId, $email, $password, $firstName, $lastName))) return 1;
		else return 0;
	}
	
	// logout
	public function logout($redirectUrl = null)
	{
		session_unset();
		session_destroy();
		setcookie('USER_TOKEN', NULL, time()-3600, '/');
		if (isset($redirectUrl)) header('Location: '.$redirectUrl);
	}
	
	// restrit access
	public function restrict($userGroupId)
	{
		// not logged in or null usergroupid
		if (!isset($this->userId) || $this->userGroupId == NULL)
		{
			header('Location: /login');
		}
		// logged in
		else
		{
			if (isset($userGroupId))
			{
				$userGroupIdArray = explode(',', $userGroupId);
				if (!in_array($this->userGroupId, $userGroupIdArray))
				{
					if (in_array($this->userGroupId, $this->userGroupAdminArray)) header('Location: /reservations/');
					else if (in_array($this->userGroupId, $this->userGroupOwnerArray)) header('Location: /reservations/');
					else $this->logout('/401');
				}
			}
		}
	}
	
	// check existing user
	public function checkEmailAvailability($email, $userId = 0)
	{
		if ($userId > 0) $rs_user = $_SESSION['DB']->querySelect('SELECT USER_EMAIL FROM USER WHERE USER_EMAIL = ? AND USER_ID != ? LIMIT 1', array($email, $userId));
		else $rs_user = $_SESSION['DB']->querySelect('SELECT USER_EMAIL FROM USER WHERE USER_EMAIL = ? LIMIT 1', array($email));
		if ($_SESSION['DB']->queryCount($rs_user)) return 1;
		else return 0;
	}
	
	// check password strength
	public function checkPasswordStrength($password)
	{
		return preg_match('/(?=^.{6,}$)(?=.*\d)(?=.*[A-Za-z]).*$/', $password);
	}
	
	// get user discount
	public function getUserDiscount($manufacturerId, $userId)
	{
		$rs_account_discount = $_SESSION['DB']->querySelect('SELECT ACCOUNT_DISCOUNT_AMT FROM ACCOUNT_DISCOUNT LEFT JOIN USER ON USER.ACCOUNT_ID = ACCOUNT_DISCOUNT.ACCOUNT_ID WHERE USER_ID = ? AND MANUFACTURER_ID = ? LIMIT 1', array($userId, $manufacturerId));
		$row_rs_account_discount = $_SESSION['DB']->queryResult($rs_account_discount);
		$totalRows_rs_account_discount = $_SESSION['DB']->queryCount($rs_account_discount);
		
		if ($totalRows_rs_account_discount)
		{
			return $row_rs_account_discount['ACCOUNT_DISCOUNT_AMT'] / 100;
		}
		else return 0;
	}
	
	// get user tax exempt
	public function getUserTaxExempt($userId)
	{
		$rs_account_tax_exempt = $_SESSION['DB']->querySelect('SELECT ACCOUNT_TAX_EXEMPT FROM ACCOUNT LEFT JOIN USER ON USER.ACCOUNT_ID = ACCOUNT.ACCOUNT_ID WHERE USER_ID = ? LIMIT 1', array($userId));
		$row_rs_account_tax_exempt = $_SESSION['DB']->queryResult($rs_account_tax_exempt);
		$totalRows_rs_account_tax_exempt = $_SESSION['DB']->queryCount($rs_account_tax_exempt);
		
		if ($totalRows_rs_account_tax_exempt && $row_rs_account_tax_exempt['ACCOUNT_TAX_EXEMPT'] == 1) return 1;
		else return 0;
	}
}
?>