<?php
session_start();

/* ===========================
   CONNEXION BASE DE DONNÉES
=========================== */

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

/* ===========================
   RÉCUPÉRATION DU PRODUIT
=========================== */

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM parfums WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);

    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$produit){
        echo "Produit introuvable";
        exit;
    }

}else{
    echo "Produit introuvable";
    exit;
}

/* ===========================
   GESTION DU CHOIX ML
=========================== */

if(isset($_POST['ml'])){
    $ml = intval($_POST['ml']);
}
elseif(isset($_POST['ml_cache'])){
    $ml = intval($_POST['ml_cache']);
}
else{
    $ml = 50;
}

/* ===========================
   GESTION QUANTITÉ
=========================== */

if(isset($_POST['quantite'])){
    $quantite = intval($_POST['quantite']);
}
else{
    $quantite = 1;
}

if(isset($_POST['plus'])){
    $quantite++;
}

if(isset($_POST['moins'])){
    if($quantite > 1){
        $quantite--;
    }
}

/* ===========================
   CALCUL DU PRIX
=========================== */

if($ml == 50){
    $prix = $produit['prix50'];
}
elseif($ml == 80){
    $prix = $produit['prix80'];
}
elseif($ml == 100){
    $prix = $produit['prix100'];
}
else{
    $prix = $produit['prix50'];
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Détail parfum</title>

<style>

/* ===========================
   STRUCTURE GLOBALE
=========================== */

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


/* ===========================
   HEADER
=========================== */

.header{
    background:black;
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:15px 40px;
    border-bottom:4px solid #7a1f2b;
}


/* ===========================
   BOUTONS MENU
=========================== */

.menu-btn{
    background:#7a1f2b;
    color:white;
    padding:10px 22px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.menu-btn:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}


/* ===========================
   BARRE LIVRAISON
=========================== */

.livraison-bar{
    background:#7a1f2b;
    color:white;
    text-align:center;
    padding:12px;
    font-weight:bold;
}


/* ===========================
   CONTENU PRODUIT
=========================== */

.container{
    flex:1;
    display:flex;
    gap:60px;
    max-width:1100px;
    margin:90px auto 50px auto;
    padding:40px;
    background:white;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
}


/* ===========================
   IMAGE PRODUIT
=========================== */

.image-box img{
    width:320px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}


/* ===========================
   TITRE PRODUIT
=========================== */

h1{
    color:#7a1f2b;
    margin-top:0;
}


/* ===========================
   BOUTONS ML
=========================== */

.ml-buttons button{
    padding:8px 14px;
    margin-right:8px;
    border:2px solid #7a1f2b;
    background:white;
    cursor:pointer;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.ml-buttons button:hover{
    background:#7a1f2b;
    color:white;
}


/* ===========================
   QUANTITÉ
=========================== */

.quantite button{
    padding:7px 13px;
    border:2px solid #7a1f2b;
    background:white;
    cursor:pointer;
    border-radius:6px;
}

.quantite button:hover{
    background:#7a1f2b;
    color:white;
}


/* ===========================
   PRIX
=========================== */

.price{
    color:#7a1f2b;
    font-size:26px;
    font-weight:bold;
    margin-top:12px;
}


/* ===========================
   DESCRIPTION
=========================== */

p{
    line-height:1.6;
}


/* ===========================
   FAVORIS
=========================== */

.btn-favoris{
    margin-top:12px;
    background:white;
    color:#7a1f2b;
    border:2px solid #7a1f2b;
    padding:9px 18px;
    border-radius:25px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-favoris:hover{
    background:#7a1f2b;
    color:white;
}


/* ===========================
   BOUTONS PANIER / RETOUR
=========================== */

.btn-group{
    display:flex;
    gap:15px;
    margin-top:25px;
}

.btn-panier,
.btn-retour{
    background:#7a1f2b;
    color:white;
    padding:12px 26px;
    border:none;
    border-radius:25px;
    cursor:pointer;
    text-decoration:none;
    font-size:16px;
    transition:0.3s;
}

.btn-panier:hover,
.btn-retour:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}


/* ===========================
   FOOTER CONTACT
=========================== */

footer{
    background:black;
    color:white;
    text-align:center;
    padding:40px 20px;
    margin-top:auto;
    border-top:4px solid #7a1f2b;
}

footer h3{
    margin-bottom:15px;
}

footer p{
    margin:8px 0;
}


/* ===========================
   RESPONSIVE
=========================== */

@media(max-width:800px){

    .container{
        flex-direction:column;
        margin:60px 20px 40px;
        padding:25px;
        gap:25px;
    }

    .image-box img{
        width:260px;
    }

    .header{
        padding:15px 20px;
    }
}

</style>

</head>

<body>

<!-- ===========================
     HEADER
=========================== -->

<div class="header">

<a href="index1.php" class="menu-btn">
Accueil
</a>

<a href="#contact" class="menu-btn">
Contact
</a>

<a href="panier.php" class="menu-btn">

Panier 🛒

<?php
if(isset($_SESSION['panier'])){
    echo " (".count($_SESSION['panier']).")";
}
?>

</a>

</div>


<!-- ===========================
     BARRE LIVRAISON
=========================== -->

<div class="livraison-bar">
🚚 Livraison gratuite à partir de 99 DT
</div>


<!-- ===========================
     CONTENU PRODUIT
=========================== -->

<div class="container">

<div class="image-box">

<img src="images/<?php echo $produit['image']; ?>">

</div>

<div>

<h1>
<?php echo $produit['nom']; ?>
</h1>

<form method="POST">

<input type="hidden"
name="ml_cache"
value="<?php echo $ml; ?>">

<div class="ml-buttons">

<button type="submit" name="ml" value="50">
50 ML
</button>

<button type="submit" name="ml" value="80">
80 ML
</button>

<button type="submit" name="ml" value="100">
100 ML
</button>

</div>

<br>

<div class="quantite">

<button type="submit" name="moins">-</button>

<input type="text"
name="quantite"
value="<?php echo $quantite; ?>"
readonly
style="width:40px;text-align:center;">

<button type="submit" name="plus">+</button>

</div>

</form>

<div class="price">
Prix : <?php echo $prix; ?> DT
</div>

<br>

<p>
<?php echo $produit['description']; ?>
</p>

<form method="POST" action="ajouter_favoris.php">

<input type="hidden" name="id" value="<?php echo $produit['id']; ?>">

<button type="submit" name="favoris" class="btn-favoris">
💖 Favoris
</button>

</form>

<div class="btn-group">

<form method="POST" action="ajouter_panier.php">

<input type="hidden" name="id"
value="<?php echo $produit['id']; ?>">

<input type="hidden" name="type"
value="parfum">

<input type="hidden" name="quantite"
value="<?php echo $quantite; ?>">

<input type="hidden" name="ml"
value="<?php echo $ml; ?>">

<input type="hidden" name="prix"
value="<?php echo $prix; ?>">

<button type="submit"
class="btn-panier">

Ajouter au panier

</button>

</form>

<a href="index1.php"
class="btn-retour">

← Retour accueil

</a>

</div>

</div>

</div>




<footer id="contact">

<h3>Contactez-nous</h3>

<p>📞 Téléphone : 94281424</p>

<p>📧 Email : bloom@parfum.com</p>

<p>📍 Adresse : Bizerte , Tunis</p>

</footer>

</body>

</html>