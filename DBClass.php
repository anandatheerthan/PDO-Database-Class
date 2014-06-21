<?php
date_default_timezone_set('Asia/Calcutta');
// Define configuration
define("DB_HOST", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
class DBClass
  {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $stmt;
    private $dbh;
    private $error;
    
    function __construct()
      {
        $this->PDOCreateConnection();
      }
    
    private function PDOCreateConnection()
      {
        // Set DSN
        $dsn     = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try
          {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
          }
        // Catch any errors
        catch (PDOException $e)
          {
            $this->error = $e->getMessage();
          }
      }
    
    public function query($query)
      {
        $this->stmt = $this->dbh->prepare($query);
      }
    public function bind($param, $value, $type = null)
      {
        if (is_null($type))
          {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
          }
		try{  
        $this->stmt->bindValue($param, $value, $type);
		}
		catch (PDOException $e)
          {
            echo $e->getMessage();
          }
      }
	  
	  public function bindParam($param, $value, $type = null)
      {
        if (is_null($type))
          {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
          }
        $this->stmt->bindParam($param, $value, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
      }
    
    public function execute()
      {
		  try{
        return $this->stmt->execute();
		  }
		  catch (PDOException $e)
          {
            echo $e->getMessage();
          }
      }
    
	  public function fetchColumn()
      {
		  try{
        return $this->stmt->fetchColumn();
		  }
		  catch (PDOException $e)
          {
            echo $e->getMessage();
          }
      }
    
    public function resultset()
      {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_BOTH);
      }
	  
	public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_BOTH);
}  
    
    public function rowCount()
      {
        return $this->stmt->rowCount();
      }
    
    public function lastInsertId()
      {
        return $this->dbh->lastInsertId();
      }
    
    public function debugDumpParams()
      {
        return $this->stmt->debugDumpParams();
      }
    
  }
  
 
?>