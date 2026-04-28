<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

if(!isset($_SESSION['user_nom'])){
    header("Location: login.php");
    exit();
}

$user_nom = $_SESSION['user_nom'];

$sql = "SELECT c.*, cl.nom, cl.email, cl.telephone, cl.adresse
        FROM commandes c
        JOIN clients cl ON c.client_id = cl.client_id
        WHERE LOWER(cl.nom) = LOWER(:nom)
        ORDER BY c.id DESC";

$stmt = $db->prepare($sql);
$stmt->execute([
    ':nom' => $user_nom
]);

$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Historique d'achat</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:white;
}

.header{
    background:black;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    border-bottom:4px solid #7a1f2b;
}

.logo{
    font-size:22px;
    font-weight:bold;
}

.menu{
    display:flex;
    gap:15px;
}

.menu-btn{
    background:#7a1f2b;
    color:white;
    text-decoration:none;
    padding:10px 22px;
    border-radius:25px;
    font-weight:bold;
}

.menu-btn:hover{
    background:#a52a3a;
}

.container{
    max-width:950px;
    margin:40px auto;
    padding:20px;
}

h1{
    text-align:center;
    color:#7a1f2b;
    margin-bottom:30px;
}

.commande{
    background:white;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 8px 22px rgba(0,0,0,0.12);
    overflow:hidden;
}

.commande-header{
    background:#7a1f2b;
    color:white;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    font-weight:bold;
}

.badge-total{
    background:white;
    color:#7a1f2b;
    padding:6px 15px;
    border-radius:20px;
}

.commande-body{
    padding:20px;
}

.info{
    color:#555;
    margin-bottom:15px;
    line-height:1.8;
}

.info span{
    color:#7a1f2b;
    font-weight:bold;
}

.articles-title{
    color:#7a1f2b;
    font-weight:bold;
    margin-bottom:12px;
    display:block;
}

.articles{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

.article{
    display:flex;
    align-items:center;
    gap:12px;
    background:#f8f8f8;
    padding:10px 15px;
    border-radius:12px;
    min-width:220px;
}

.article img{
    width:60px;
    height:75px;
    object-fit:cover;
    border-radius:6px;
}

.article h4{
    margin:0 0 5px;
    font-size:15px;
}

.article p{
    margin:0;
    color:#7a1f2b;
    font-weight:bold;
}

.vide{
    text-align:center;
    color:#777;
    margin-top:50px;
}
</style>
</head>

<body>

<div class="header">

    <div class="logo">Bloom by islem</div>

    <div class="menu">
        <a href="index1.php" class="menu-btn">Accueil</a>
        <a href="favoris.php" class="menu-btn">Favoris 💖</a>

        <a href="panier.php" class="menu-btn">
            Panier 🛒
            <?php
            if(isset($_SESSION['panier']) && count($_SESSION['panier']) > 0){
                echo " (".count($_SESSION['panier']).")";
            }
            ?>
        </a>
    </div>

</div>

<div class="container">

<h1>📋 Historique d'achat</h1>

<?php if(count($commandes) == 0): ?>

    <div class="vide">
        <h3>Aucune commande trouvée</h3>
    </div>

<?php else: ?>

<?php foreach($commandes as $cmd): ?>

<?php
$sqlArt = "SELECT * FROM details_commande 
           WHERE commande_id = :commande_id";

$stmtArt = $db->prepare($sqlArt);
$stmtArt->execute([
    ':commande_id' => $cmd['id']
]);

$articles = $stmtArt->fetchAll(PDO::FETCH_ASSOC);

$articles_groupes = [];

foreach($articles as $art){

    $key = $art['nom'] . '_' . $art['prix'] . '_' . $art['image'];

    if(isset($articles_groupes[$key])){
        $articles_groupes[$key]['quantite'] += $art['quantite'];
    }else{
        $articles_groupes[$key] = $art;
    }
}
?>

<div class="commande">

    <div class="commande-header">
        <span>
            Commande #<?php echo $cmd['id']; ?>
            - <?php echo htmlspecialchars($cmd['nom']); ?>

            <?php
            if(isset($cmd['date_commande'])){
                echo " | ".date('d/m/Y à H:i', strtotime($cmd['date_commande']));
            }
            ?>
        </span>

        <span class="badge-total">
            Total : <?php echo number_format($cmd['total'], 2); ?> DT
        </span>
    </div>

    <div class="commande-body">

        <div class="info">
            👤 Nom :
            <span><?php echo htmlspecialchars($cmd['nom']); ?></span><br>

            📧 Email :
            <span><?php echo htmlspecialchars($cmd['email']); ?></span><br>

            📞 Téléphone :
            <span><?php echo htmlspecialchars($cmd['telephone']); ?></span><br>

            📦 Adresse :
            <span><?php echo htmlspecialchars($cmd['adresse']); ?></span>
        </div>

        <span class="articles-title">
            🛍 Articles commandés :
        </span>

        <div class="articles">

            <?php foreach($articles_groupes as $art): ?>

                <div class="article">
                    <img src="images/<?php echo htmlspecialchars($art['image']); ?>" alt="Produit">

                    <div>
                        <h4><?php echo htmlspecialchars($art['nom']); ?></h4>

                        <p>
                            <?php echo number_format($art['prix'], 2); ?> DT
                            x <?php echo $art['quantite']; ?>
                        </p>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

<?php include 'footer.php'; ?>

</body>
</html>