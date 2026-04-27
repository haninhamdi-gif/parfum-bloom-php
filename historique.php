<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT c.*, cl.nom, cl.email, cl.telephone, cl.adresse
        FROM commandes c
        JOIN clients cl ON c.client_id = cl.client_id
        WHERE c.user_id = :user_id
        ORDER BY c.id DESC";

$stmt = $db->prepare($sql);
$stmt->execute([
    ':user_id' => $user_id
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
    display:flex;
    flex-direction:column;
    min-height:100vh;
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

.main-content{
    flex:1;
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
    flex-wrap:wrap;
    gap:10px;
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

.articles{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
    margin-top:15px;
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
    font-size:14px;
}

.article p{
    margin:0;
    color:#7a1f2b;
    font-weight:bold;
}

.vide{
    text-align:center;
    background:white;
    padding:50px;
    border-radius:14px;
    color:#777;
}

.btn-retour{
    display:inline-block;
    margin-top:15px;
    background:#7a1f2b;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:25px;
    font-weight:bold;
}

.btn-retour:hover{
    background:#a52a3a;
}

.btn-supprimer{
    background:#dc3545;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:25px;
    font-weight:bold;
    cursor:pointer;
    margin-top:20px;
    transition:0.3s;
}

.btn-supprimer:hover{
    background:#b02a37;
    transform:translateY(-2px);
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
            if(isset($_SESSION['panier'])){
                echo " (".count($_SESSION['panier']).")";
            }
            ?>
        </a>
    </div>

</div>

<div class="main-content">

<div class="container">

<h1>📋 Historique d'achat</h1>

<?php if(count($commandes) == 0): ?>

<div class="vide">
    <h3>Aucune commande trouvée.</h3>

    <a href="index1.php" class="btn-retour">
        Découvrir nos parfums
    </a>
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
?>

<div class="commande">

    <div class="commande-header">

        <span>
            Commande #<?php echo $cmd['id']; ?> -
            <?php echo htmlspecialchars($cmd['nom']); ?>

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

        <strong style="color:#7a1f2b;">
            🛍 Articles commandés :
        </strong>

        <div class="articles">

        <?php foreach($articles as $art): ?>

            <div class="article">

                <img src="images/<?php echo htmlspecialchars($art['image']); ?>">

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

<?php endforeach; ?>

<?php endif; ?>

</div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>