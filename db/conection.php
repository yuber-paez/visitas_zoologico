<?php 
class Database 
{
    private $hostname = "127.0.0.1";
    private $database = "zoologico";
    private $username = "root";
    private $password = "";
    private $chaerset = "utf8";
    
    public function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->chaerset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo "Error de conexion: " . $e->getMessage();
            exit();
        }
    }
}


?>