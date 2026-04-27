<?php

session_start();

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];

$sql = "SELECT * FROM parfums WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$produit = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Détail Produit</title>
</head>

<body>

<h2>
<?php echo $produit['nom']; ?>
</h2>

<img src="images/<?php echo $produit['image']; ?>" width="300">

<p>
Prix :
<?php echo $produit['prix']; ?> DT
</p>


<a href="ajouter_panier.php?id=<?php echo $produit['id']; ?>">
Ajouter au panier
</a>

<br><br>

<a href="panier.php">
Voir panier
</a>
<a href="contact.php" class="menu-btn">
Contact
</a>
</body>

</html>