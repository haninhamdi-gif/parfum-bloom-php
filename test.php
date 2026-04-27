<?php

require_once "config/Database.php";

$db = (new Database())->getConnection();

if($db){

echo "Connexion OK";

}else{

echo "Connexion échouée";

}

?>