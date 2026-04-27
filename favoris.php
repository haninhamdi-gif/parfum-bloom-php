<?php
session_start();

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mes favoris</title>

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

.header{
    background:black;
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:15px 40px;
    border-bottom:4px solid #7a1f2b;
}

.logo{
    font-size:22px;
    font-weight:bold;
    color:#ffd6de;
}

.menu{
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

.main-content{
    flex:1;
}

.title{
    text-align:center;
    color:#7a1f2b;
    margin:40px 0 30px;
    font-size:32px;
}

.favoris-container{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:30px;
    padding:20px 40px 80px;
}

.card{
    background:white;
    width:230px;
    padding:22px;
    border-radius:18px;
    text-align:center;
    border:1px solid #eeeeee;
    box-shadow:0 8px 22px rgba(0,0,0,0.10);
}

.card img{
    width:150px;
    height:150px;
    object-fit:contain;
}

.card h3{
    margin:15px 0 10px;
}

.prix{
    color:#7a1f2b;
    font-weight:bold;
    font-size:18px;
}

.btn-detail,
.btn-supprimer{
    display:block;
    width:100%;
    margin-top:10px;
    padding:10px;
    border-radius:25px;
    font-weight:bold;
    text-decoration:none;
    border:none;
    cursor:pointer;
    box-sizing:border-box;
}

.btn-detail{
    background:#7a1f2b;
    color:white;
}

.btn-supprimer{
    background:#333;
    color:white;
}

.btn-detail:hover{
    background:#a52a3a;
}

.btn-supprimer:hover{
    background:black;
}

.empty{
    text-align:center;
    font-size:20px;
    color:#555;
}

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

<div class="header">

    <div class="logo">bloom by islem</div>

    <div class="menu">

        <a href="index1.php" class="menu-btn">Accueil</a>

        <a href="#contact" class="menu-btn">Contact</a>

        <a href="panier.php" class="menu-btn">
            Panier 🛒
            <?php
            if(isset($_SESSION['panier'])){
                echo " (".count($_SESSION['panier']).")";
            }
            ?>
        </a>

    </div>

</div>

<div class="main-content">

<h1 class="title">💖 Mes favoris</h1>

<div class="favoris-container">

<?php
if(isset($_SESSION['favoris']) && count($_SESSION['favoris']) > 0){

    foreach($_SESSION['favoris'] as $id){

        $sql = "SELECT * FROM parfums WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if($produit){
?>

<div class="card">

    <img src="images/<?php echo $produit['image']; ?>">

    <h3><?php echo $produit['nom']; ?></h3>

    <p class="prix"><?php echo $produit['prix50']; ?> DT</p>

    <a href="detail.php?id=<?php echo $produit['id']; ?>" class="btn-detail">
        Voir détail
    </a>

    <form method="POST" action="supprimer.php">
        <input type="hidden" name="id" value="<?php echo $produit['id']; ?>">

        <button type="submit" class="btn-supprimer">
            Supprimer
        </button>
    </form>

</div>

<?php
        }
    }

}else{
    echo "<p class='empty'>Aucun favori ajouté 💔</p>";
}
?>

</div>

</div>

<div id="contact" class="contact-footer">

    <h3>Contactez-nous</h3>

    <p>📞 Téléphone : 94281424</p>

    <p>📧 Email : bloom@parfum.com</p>

    <p>📍 Adresse : Bizerte , Tunis</p>

</div>

</body>
</html>