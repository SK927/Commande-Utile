<?php 
 
  class MySQLSessionHandler
  {
    private $connection;

    public function __construct()
    {
      include("mysql/mysql_credentials.php");
      
      $this->connection = new mysqli(HOST, USERNAME, PASSWORD, DB);
      
      session_set_save_handler([$this, "open"], [$this, "close"], [$this, "read"], [$this, "write"], [$this, "destroy"], [$this, "gc"]);
      register_shutdown_function('session_write_close');
      session_start();
    }

    public function open($savePath, $sessionName)
    {
      return true;
    }

    public function close()
    {
      return true;
    }

    public function read($sessionId)
    {
      $stmt = $this->connection->prepare("SELECT session_data FROM #PREFIX_Sessions WHERE session_id = '$sessionId'");
      $stmt->execute();
      $stmt->bind_result($session_data);
      $stmt->fetch();
      return $session_data ? $session_data : "";
    }
    
    public function write($sessionId, $data)
    {
      $time = time();
      $data = mysqli_real_escape_string($this->connection, $data);
      $stmt = $this->connection->prepare("REPLACE INTO #PREFIX_Sessions (session_id, created, session_data) VALUES ('$sessionId', $time, '$data')");
      return $stmt->execute();
    }

    public function destroy($sessionId)
    {
      $stmt = $this->connection->prepare("DELETE FROM #PREFIX_Sessions WHERE session_id = '$sessionId'");
      return $stmt->execute();
    }
    
    public function gc($maxlifetime)
    {
      $past = time() - $maxlifetime;
      $stmt = $this->connection->prepare("DELETE FROM #PREFIX_Sessions WHERE created < $past");
      return $stmt->execute();
    }
  }

  $sessionHandler = new MySQLSessionHandler();
  
?>
