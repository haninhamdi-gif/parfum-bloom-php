<?php
session_start();

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

if(isset($_POST['nom'])){

$nom = $_POST['nom'];
$telephone = $_POST['telephone'];
$adresse = $_POST['adresse'];


$sql = "INSERT INTO clients (nom, telephone, adresse)
VALUES (?, ?, ?)";

$stmt = $db->prepare($sql);
$stmt->execute([$nom,$telephone,$adresse]);


unset($_SESSION['panier']);

}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<title>Commande validée</title>

<style>

body{
font-family:Arial;
background:#f8f0f2;
text-align:center;
padding-top:100px;
}

.box{

background:white;
width:400px;
margin:auto;
padding:40px;

border-radius:10px;

}

a{

background:#7a1f2b;
color:white;

padding:10px 20px;

border-radius:6px;

text-decoration:none;

}

</style>

</head>

<body>

<div class="box">

<h2>✅ Commande validée</h2>

<p>
Merci pour votre commande !
</p>

<br>

<a href="index1.php">

Retour à l'accueil

</a>

</div>

</body>

</html>