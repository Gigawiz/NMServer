<?php
	class User {
		public $cookie;
		public $username;
		public $password;
		private $hashVal;
		
		function __construct()
		{
			
		}
		
		function createSalt()
		{
			$text = md5(uniqid(rand(), TRUE));
			return substr($text, 0, 3);
		}
		
		function Login() {
			if (empty($this->username) || !isset($this->username) || empty($this->password) || !isset($this->password))
			{
				$this->cookie = null;
				return false;
			}
			$db = Database::getInstance();
			$result = $db->query("SELECT username,password,salt,hash FROM `users` WHERE `username`='".$this->username."'");
			$userInfo = array();
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$userInfo += array("username" => $row["username"]);
					$userInfo += array("password" => $row["password"]);
					$userInfo += array("salt" => $row["salt"]);
					$userInfo += array("hash" => $row["hash"]);
				}
			} else {
				printf('No record found.<br />');
			}
			$inPass = hash('sha256', $this->password.$userInfo['salt']);
			if ($inPass != $userInfo['password']){
				return false;
			}
			$this->hashVal = $userInfo['hash'];
			$this->cookie = $this->hashVal;
			return true;
		}
		
		function Register() {
			if (empty($this->username) || !isset($this->username) || empty($this->password) || !isset($this->password))
			{
				return "Empty Values!";
			}
			if ($this->checkExists())
			{
				return "User Exists!";
			}
			$salt = $this->createSalt();
			$inPass = hash('sha256', $this->password.$salt);
			$hash = md5($this->username."".$this->password);
			
			$db = Database::getInstance();
			$fields = array("username", "password", "salt", "hash");
			$vals = array($this->username, $inPass, $salt, $hash);
			$result = $db->insert("users", $fields, $vals);
			return $result;
		}
		
		function checkExists() {
			$db = Database::getInstance();
			$result = $db->query("SELECT * FROM `users` WHERE `username`='".$this->username."'");
			if ($result->num_rows > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
?>