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
<title>Bloom by islem</title>

<style>

body{
    margin:0;
    font-family:Arial;
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background:#ffffff;
}


.header{
    background:black;
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:18px 45px;
    border-bottom:0;
    position:sticky;
    top:0;
    z-index:1000;
    box-shadow:0 4px 12px rgba(0,0,0,0.25);
}

.logo{
    font-size:24px;
    font-weight:bold;
    letter-spacing:1px;
    color:#ffd6de;
}

.menu-center{
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%,-50%);
    display:flex;
    gap:12px;
}

.menu-right{
    display:flex;
    align-items:center;
}

.menu-btn{
    background:#7a1f2b;
    color:white;
    text-decoration:none;
    padding:10px 20px;
    border-radius:25px;
    font-weight:bold;
    font-size:15px;
    transition:0.3s;
}

.menu-btn:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}


.livraison-bar{
    background:#7a1f2b;
    color:white;
    text-align:center;
    padding:14px;
    font-size:17px;
    font-weight:bold;
    position:sticky;
    top:74px;
    z-index:999;
    margin:0;
}

.compte-btn{
    position:absolute;
    left:20px;
    top:8px;
}



.user-box{
    text-align:center;
    margin:20px 0;
}

.user-box span{
    display:block;
    font-weight:bold;
    color:#7a1f2b;
    font-size:17px;
    margin-bottom:10px;
}

.user-box a{
    display:inline-block;
    background:#7a1f2b;
    color:white;
    padding:10px 22px;
    margin:5px;
    border-radius:25px;
    font-weight:bold;
    text-decoration:none;
    transition:0.3s;
}

.user-box a:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}



.section{
    background:#ffffff;
    margin:40px auto;
    padding:30px 25px;
    width:95%;
    max-width:1300px;
    border-radius:18px;
    border:1px solid #e6e6e6;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.section h2{
    text-align:center;
    font-size:34px;
    font-weight:bold;
    color:#7a1f2b;
    margin-bottom:30px;
    position:relative;
    letter-spacing:1px;
}

.section h2:after{
    content:"";
    width:90px;
    height:3px;
    background:#7a1f2b;
    display:block;
    margin:12px auto 0;
    border-radius:3px;
}


.products{
    background:#ffffff;
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(190px, 1fr));
    gap:28px;
    align-items:stretch;
}

.card{
    background:transparent;
    box-shadow:none;
    border:none;
    min-height:270px;
    padding:20px;
    border-radius:18px;
    transition:0.3s;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:space-between;
}

.card:hover{
    transform:translateY(-7px);
}

.card img{
    width:145px;
    height:160px;
    object-fit:contain;
    border-radius:0;
    background:transparent;
    padding:0;
    border:none;
    box-shadow:none;
}

.card h4{
    font-size:16px;
    margin:14px 0 10px;
    min-height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
}

.btn{
    background:#7a1f2b;
    color:white;
    padding:9px 18px;
    border-radius:20px;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
    display:inline-block;
    transition:0.3s;
}

.btn:hover{
    background:#a52a3a;
    transform:scale(1.05);
}


@media(max-width:900px){

    .header{
        flex-direction:column;
        gap:15px;
    }

    .menu-center{
        position:static;
        transform:none;
        flex-wrap:wrap;
        justify-content:center;
    }

    .livraison-bar{
        top:120px;
    }

    .section{
        padding:25px 18px;
    }
}

</style>
</head>

<body>

<div class="header">

    <div class="logo">
        Bloom by islem
    </div>

    <div class="menu-center">
        <a href="index1.php" class="menu-btn">Accueil</a>
        <a href="#contact" class="menu-btn">Contact</a>
        <a href="favoris.php" class="menu-btn">💖</a>
        <a href="historique.php" class="menu-btn">📋 Historique</a>
    </div>

    <div class="menu-right">
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

<div class="livraison-bar">

    <a href="login.php" class="menu-btn compte-btn">
        compte
    </a>

    🚚 Livraison gratuite à partir de <strong>99 DT</strong>

</div>

<?php if(isset($_SESSION['user_nom'])): ?>

<div class="user-box">

    <span>
        Bienvenue <?php echo $_SESSION['user_nom']; ?>
    </span>

    <a href="logout.php">Déconnexion</a>

</div>

<?php else: ?>

<div class="user-box">

    <a href="login.php">Connexion</a>

    <a href="inscription.php">Inscription</a>

</div>

<?php endif; ?>

<div class="section">

<h2>Parfum Homme</h2>

<div class="products">

<?php
$sql = "SELECT * FROM parfums WHERE categorie_id = 1";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

echo '

<div class="card">

    <img src="images/'.$row["image"].'">

    <h4>'.$row["nom"].'</h4>

    <a href="detail.php?id='.$row["id"].'" class="btn">
        Voir plus
    </a>

</div>

';

}
?>

</div>
</div>

<div class="section">

<h2>Parfum Femme</h2>

<div class="products">

<?php
$sql = "SELECT * FROM parfums WHERE categorie_id = 2";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

echo '

<div class="card">

    <img src="images/'.$row["image"].'">

    <h4>'.$row["nom"].'</h4>

    <a href="detail.php?id='.$row["id"].'" class="btn">
        Voir plus
    </a>

</div>

';

}
?>

</div>
</div>

<div class="section">

<h2>Coffrets</h2>

<div class="products">

<?php
$sql = "SELECT * FROM coffrets";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

echo '

<div class="card">

    <img src="images/'.$row["image"].'">

    <h4>'.$row["nom"].'</h4>

    <a href="detail_coffret.php?id='.$row["id"].'" class="btn">
        Voir plus
    </a>

</div>

';

}
?>

</div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>