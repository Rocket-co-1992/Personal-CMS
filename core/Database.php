<?php
namespace Core;

class Database
{
    private $connection;
    private $config;
    
    public function __construct()
    {
        global $dbConfig;
        $this->config = $dbConfig;
        $this->connect();
    }
    
    private function connect()
    {
        $this->connection = new \mysqli(
            $this->config['host'],
            $this->config['username'],
            $this->config['password'],
            $this->config['database']
        );
        
        if ($this->connection->connect_error) {
            die('Database connection failed: ' . $this->connection->connect_error);
        }
        
        $this->connection->set_charset('utf8mb4');
    }
    
    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new \Exception('Query preparation failed: ' . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = '';
            $bindParams = [];
            
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } elseif (is_string($param)) {
                    $types .= 's';
                } else {
                    $types .= 'b';
                }
                $bindParams[] = $param;
            }
            
            $stmt->bind_param($types, ...$bindParams);
        }
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        return true;
    }
    
    public function close()
    {
        $this->connection->close();
    }
}
