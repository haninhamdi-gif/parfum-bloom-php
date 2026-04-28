<?php
session_start();

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "SELECT * FROM coffrets WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);

    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

}else{
    echo "Coffret introuvable";
    exit;
}

if(!$produit){
    echo "Coffret introuvable";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Détail coffret</title>

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
    color:#222;
}



.header{
    background:black;
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:15px 40px;
    border-bottom:4px solid #7a1f2b;
    position:relative;
    box-shadow:0 4px 12px rgba(0,0,0,0.25);
}

.logo{
    font-size:22px;
    font-weight:bold;
    white-space:nowrap;
    color:#ffd6de;
}




.menu-center{
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%,-50%);
    display:flex;
    gap:15px;
}

.menu-right{
    display:flex;
    align-items:center;
}




.menu-btn{
    background:#7a1f2b;
    color:white;
    text-decoration:none;
    padding:10px 25px;
    border-radius:25px;
    font-weight:bold;
    font-size:16px;
    transition:0.3s;
}

.menu-btn:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}




.container{
    flex:1;
    display:flex;
    gap:60px;
    max-width:1100px;
    width:85%;
    margin:90px auto 50px auto;
    padding:40px;
    background:white;
    border-radius:22px;
    border:1px solid #eeeeee;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
}




.image-box img{
    width:320px;
    max-height:420px;
    object-fit:contain;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}




h1{
    color:#7a1f2b;
    margin-top:0;
}

.price{
    color:#7a1f2b;
    font-size:26px;
    font-weight:bold;
    margin-top:15px;
}



p{
    font-size:16px;
    line-height:1.6;
    color:#444;
    max-width:500px;
}




.btn-retour{
    background:#7a1f2b;
    color:white;
    padding:12px 25px;
    border:none;
    border-radius:25px;
    text-decoration:none;
    display:inline-block;
    margin-top:20px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
    transition:0.3s;
}

.btn-retour:hover{
    background:#a52a3a;
    transform:translateY(-2px);
}




footer{
    background:black;
    color:white;
    text-align:center;
    padding:45px 20px;
    margin-top:auto;
    border-top:4px solid #7a1f2b;
}

footer h3{
    color:white;
    font-size:20px;
    margin-bottom:20px;
}

footer p{
    color:white;
    margin:10px auto;
    font-size:15px;
    max-width:none;
}




@media(max-width:850px){

    .header{
        flex-direction:column;
        gap:15px;
        padding:15px 20px;
    }

    .menu-center{
        position:static;
        transform:none;
        flex-wrap:wrap;
        justify-content:center;
    }

    .container{
        flex-direction:column;
        width:85%;
        margin:60px auto 40px auto;
        padding:25px;
        gap:25px;
        text-align:center;
    }

    .image-box img{
        width:260px;
    }

    p{
        max-width:100%;
    }
}

</style>

</head>

<body>
    
<div class="header">

    <div class="logo">
        bloom by islem
    </div>

    <div class="menu-center">
        <a href="index1.php" class="menu-btn">Accueil</a>
        <a href="#contact" class="menu-btn">Contact</a>
        <a href="login.php" class="menu-btn">compte</a>
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

<div class="container">

    <div class="image-box">
        <img src="images/<?php echo $produit['image']; ?>">
    </div>

    <div>

        <h1><?php echo $produit['nom']; ?></h1>

        <div class="price">
            <?php echo $produit['prix']; ?> DT
        </div>

        <p style="font-size:16px;line-height:1.6;color:#444;max-width:500px;">
            <?php echo $produit['description']; ?>
        </p>

        <a href="index1.php" class="btn-retour">
            ← Retour à l'accueil
        </a>

        <form method="POST" action="ajouter_panier.php" style="display:inline;">

            <input type="hidden"
            name="id"
            value="<?php echo $produit['id']; ?>">

            <input type="hidden"
            name="type"
            value="coffret">

            <input type="hidden"
            name="quantite"
            value="1">

            <input type="hidden"
            name="prix"
            value="<?php echo $produit['prix']; ?>">

            <button type="submit" class="btn-retour">
                Ajouter au panier
            </button>

        </form>

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