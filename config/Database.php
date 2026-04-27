<?php

class Database {

private $host = "localhost";
private $port = "5433"; // ← ICI
private $db_name = "parfum"; // ← changer avec le vrai nom
private $username = "postgres";
private $password = "hanin123";

public function getConnection(){

try {

$conn = new PDO(
"pgsql:host=$this->host;port=$this->port;dbname=$this->db_name",
$this->username,
$this->password
);

$conn->setAttribute(
PDO::ATTR_ERRMODE,
PDO::ERRMODE_EXCEPTION
);

return $conn;

}
catch(PDOException $e){

echo "Erreur connexion: "
. $e->getMessage();

return null;

}

}

}

?>