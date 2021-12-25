<?php
class Database
{
    protected static $_instance = null;

    protected $_conn = null;

    protected $_config = array(
        'username' => 'dbuser',
        'password' => 'dbpass',
        'hostname' => 'localhost',
        'database' => 'dbname'
    );

    protected function __construct() {
    }

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection() {
        if (is_null($this->_conn)) {
            $db = $this->_config;
            $this->_conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$this->_conn->select_db($db['database']);
        }
        return $this->_conn;
    }

    public function query($query) {
		return $this->getConnection()->query($query);
        //return mysqli_query($this->getConnection(), $query);
    }
	
	public function insert($table, $fields, $values) {
		$ret = "";
		if (!is_array($values))
		{
			return false;
		}
		if (!is_array($fields))
		{
			return false;
		}
		$vals = "";
		$params = "";
		for ($i=0; $i<count($fields);$i++)
		{
			if ($i == 0)
			{
				$vals ="?";
				$params="s";
			}
			else {
				$vals .= ",?";
				$params .= "s";
			}
		}
		$conn = $this->getConnection();
		$stmt = $conn->prepare("INSERT INTO `".$table."` (".implode(",", $fields).") VALUES (".$vals.")");
		$stmt->bind_param($params, ...$values);
		$stmt->execute();
		$stmt->close();
    }
}