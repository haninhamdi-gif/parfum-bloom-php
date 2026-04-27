<?php
session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['panier']) || count($_SESSION['panier']) == 0){
    header("Location: panier.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['valider'])){

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $sqlClient = "INSERT INTO clients
    (user_id, nom, email, telephone, adresse)
    VALUES
    (:user_id, :nom, :email, :telephone, :adresse)
    RETURNING client_id";

    $stmtClient = $db->prepare($sqlClient);
    $stmtClient->execute([
        ':user_id' => $user_id,
        ':nom' => $nom,
        ':email' => $email,
        ':telephone' => $telephone,
        ':adresse' => $adresse
    ]);

    $client_id = $stmtClient->fetchColumn();

    $total = 0;

    foreach($_SESSION['panier'] as $item){

        if(is_array($item)){
            $id = $item['id'];
            $quantite = isset($item['quantite']) ? $item['quantite'] : 1;
        }else{
            $id = $item;
            $quantite = 1;
        }

        $sqlProduit = "SELECT * FROM parfums WHERE id = ?";
        $stmtProduit = $db->prepare($sqlProduit);
        $stmtProduit->execute([$id]);
        $produit = $stmtProduit->fetch(PDO::FETCH_ASSOC);

        if($produit){
            $total += $produit['prix50'] * $quantite;
        }
    }

    $sqlCommande = "INSERT INTO commandes
    (user_id, client_id, total)
    VALUES
    (:user_id, :client_id, :total)
    RETURNING id";

    $stmtCommande = $db->prepare($sqlCommande);
    $stmtCommande->execute([
        ':user_id' => $user_id,
        ':client_id' => $client_id,
        ':total' => $total
    ]);

    $commande_id = $stmtCommande->fetchColumn();

    foreach($_SESSION['panier'] as $item){

        if(is_array($item)){
            $id = $item['id'];
            $quantite = isset($item['quantite']) ? $item['quantite'] : 1;
        }else{
            $id = $item;
            $quantite = 1;
        }

        $sqlProduit = "SELECT * FROM parfums WHERE id = ?";
        $stmtProduit = $db->prepare($sqlProduit);
        $stmtProduit->execute([$id]);
        $produit = $stmtProduit->fetch(PDO::FETCH_ASSOC);

        if($produit){

            $sqlDetail = "INSERT INTO details_commande
            (commande_id, nom, image, prix, quantite)
            VALUES
            (:commande_id, :nom, :image, :prix, :quantite)";

            $stmtDetail = $db->prepare($sqlDetail);
            $stmtDetail->execute([
                ':commande_id' => $commande_id,
                ':nom' => $produit['nom'],
                ':image' => $produit['image'],
                ':prix' => $produit['prix50'],
                ':quantite' => $quantite
            ]);
        }
    }

    unset($_SESSION['panier']);

    header("Location: historique.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Confirmation commande</title>

<style>

html{
scroll-behavior:smooth;
}

body{
margin:0;
font-family:Arial, sans-serif;
background:white;
display:flex;
flex-direction:column;
min-height:100vh;
}

/* ================= HEADER ================= */

.header{
background:black;
color:white;
display:flex;
align-items:center;
justify-content:space-between;
padding:15px 40px;
border-bottom:4px solid #7a1f2b;
position:relative;
}

.logo{
font-size:22px;
font-weight:bold;
}

.menu-center{
position:absolute;
left:50%;
top:50%;
transform:translate(-50%,-50%);
display:flex;
gap:15px;
}

.menu-btn{
background:#7a1f2b;
color:white;
text-decoration:none;
padding:10px 25px;
border-radius:25px;
font-weight:bold;
}

.menu-btn:hover{
background:#a52a3a;
}

/* ================= CONTAINER ================= */

.container{
width:440px;
margin:90px auto;
background:white;
padding:35px;
border-radius:22px;
border:1px solid #eeeeee;
box-shadow:0 10px 28px rgba(0,0,0,0.12);
}

.main-content{
flex:1;
}

/* ================= FORM ================= */

h2{
text-align:center;
color:#7a1f2b;
margin-bottom:25px;
}

label{
display:block;
margin-top:14px;
font-weight:bold;
}

input,textarea{
width:100%;
padding:12px;
border-radius:10px;
border:1px solid #ccc;
margin-top:6px;
}

textarea{
min-height:90px;
resize:none;
}

button{
margin-top:25px;
padding:14px;
width:100%;
background:#7a1f2b;
color:white;
border:none;
border-radius:25px;
font-size:16px;
font-weight:bold;
cursor:pointer;
}

button:hover{
background:#a52a3a;
}

/* ================= CONTACT ================= */

.contact-footer{
background:black;
color:white;
text-align:center;
padding:35px 20px;
border-top:4px solid #7a1f2b;
margin-top:auto;
}

.contact-footer h3{
margin-bottom:15px;
}

.contact-footer p{
margin:6px 0;
}

</style>

</head>

<body>

<!-- HEADER -->

<div class="header">

<div class="logo">
bloom by islem
</div>

<div class="menu-center">

<a href="index1.php" class="menu-btn">
Accueil
</a>

<a href="#contact" class="menu-btn">
Contact
</a>

<a href="panier.php" class="menu-btn">
Panier 🛒
</a>

</div>

</div>

<div class="main-content">

<div class="container">

<h2>Informations Client</h2>

<form method="POST">

<label>Nom :</label>
<input type="text" name="nom" required>

<label>Email :</label>
<input type="email" name="email" required>

<label>Téléphone :</label>
<input type="text" name="telephone" required>

<label>Adresse :</label>
<textarea name="adresse" required></textarea>

<button type="submit" name="valider">
Valider commande
</button>

</form>

</div>

</div>

<!-- CONTACT FOOTER -->

<div id="contact" class="contact-footer">

<h3>Contactez-nous</h3>

<p>📞 Téléphone : 25 000 000</p>

<p>📧 Email : bloom@parfum.com</p>

<p>📍 Adresse : Bizerte , Tunisie</p>

</div>

</body>
</html>