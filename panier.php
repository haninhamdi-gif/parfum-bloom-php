<?php
session_start();

$livraison = 4.500;

/* Regrouper les produits identiques */
$grouped = [];

if(isset($_SESSION['panier'])){

    foreach($_SESSION['panier'] as $index => $item){

        if(!is_array($item)){
            continue;
        }

        $key = $item['id'] . '_' . $item['type'] . '_' . $item['ml'];

        if(isset($grouped[$key])){

            $grouped[$key]['quantite']++;

        }else{

            $item['quantite'] = 1;

            /* garder l'index original pour supprime.php */
            $item['index_original'] = $index;

            $grouped[$key] = $item;
        }
    }
}

/* Calcul total */
$total = 0;

foreach($grouped as $item){
    $total += $item['prix'] * $item['quantite'];
}

/* Livraison gratuite dès 99 DT */
if($total == 0){
    $livraison_finale = 0;
}
elseif($total >= 99){
    $livraison_finale = 0;
}
else{
    $livraison_finale = $livraison;
}

$total_final = $total + $livraison_finale;
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Votre panier</title>

<style>
body{
margin:0;
font-family:Arial;
background:white;
min-height:100vh;
display:flex;
flex-direction:column;
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
}

.logo{
font-size:22px;
font-weight:bold;
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
gap:10px;
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

h2{
text-align:center;
margin:40px 0;
}

.table-box{
width:85%;
margin:auto;
background:white;
border-radius:18px;
box-shadow:0 10px 28px rgba(0,0,0,0.10);
overflow:hidden;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#7a1f2b;
color:white;
padding:16px;
}

td{
padding:18px;
border-bottom:1px solid #eee;
text-align:center;
}

tr:hover{
background:#fafafa;
}

.product{
display:flex;
align-items:center;
gap:15px;
justify-content:center;
}

.product img{
width:80px;
height:80px;
object-fit:contain;
background:#f7f7f7;
border-radius:10px;
padding:5px;
}

.btn-delete{
background:linear-gradient(135deg,#dc3545,#b02a37);
color:white;
padding:12px 25px;
border:none;
border-radius:40px;
cursor:pointer;
font-weight:bold;
font-size:14px;
transition:0.3s;
box-shadow:0 5px 12px rgba(220,53,69,0.25);
}

.btn-delete:hover{
background:linear-gradient(135deg,#b02a37,#dc3545);
transform:translateY(-3px);
}

.btn-confirm{
background:linear-gradient(135deg,#7a1f2b,#a52a3a);
color:white;
padding:16px 30px;
border:none;
border-radius:40px;
cursor:pointer;
font-weight:bold;
font-size:16px;
transition:0.3s;
width:100%;
box-shadow:0 6px 15px rgba(122,31,43,0.25);
}

.btn-confirm:hover{
background:linear-gradient(135deg,#a52a3a,#7a1f2b);
transform:translateY(-3px);
}

.resume-box{
width:85%;
margin:30px auto;
background:white;
border-radius:18px;
box-shadow:0 10px 28px rgba(0,0,0,0.10);
padding:25px 35px;
box-sizing:border-box;
}

.resume-line{
display:flex;
justify-content:space-between;
margin:12px 0;
font-size:16px;
}

.resume-total{
border-top:2px solid #eee;
padding-top:15px;
margin-top:15px;
font-size:20px;
font-weight:bold;
color:#7a1f2b;
display:flex;
justify-content:space-between;
}

.livraison-gratuite{
color:green;
font-weight:bold;
}

.panier-vide{
text-align:center;
padding:60px;
color:#777;
font-size:18px;
}
</style>
</head>

<body>

<div class="header">

    <div class="logo">bloom by islem</div>

    <div class="menu-center">
        <a href="index1.php" class="menu-btn">Accueil</a>
        <a href="#contact" class="menu-btn">Contact</a>
        <a href="favoris.php" class="menu-btn">💖</a>
    </div>

    <div class="menu-right">

        <?php if(isset($_SESSION['user_nom'])): ?>

            <span style="color:white;font-weight:bold;">
                👤 <?php echo $_SESSION['user_nom']; ?>
            </span>

            <a href="logout.php" class="menu-btn">Déconnexion</a>

        <?php else: ?>

            <a href="login.php" class="menu-btn">Connexion</a>

        <?php endif; ?>

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

<h2>Votre panier</h2>

<?php if(empty($grouped)): ?>

<div class="panier-vide">
    🛒 Votre panier est vide.
</div>

<?php else: ?>

<div class="table-box">

<table>

<tr>
    <th>Produit</th>
    <th>Prix unitaire</th>
    <th>Quantité</th>
    <th>Sous-total</th>
    <th>Action</th>
</tr>

<?php foreach($grouped as $key => $produit): ?>

<tr>

    <td>
        <div class="product">

            <img src="images/<?php echo $produit['image']; ?>">

            <div>
                <b><?php echo $produit['nom']; ?></b>
                <br>

                <?php
                if(!empty($produit['ml'])){
                    echo $produit['ml']." ML";
                }
                ?>
            </div>

        </div>
    </td>

    <td>
        <?php echo number_format($produit['prix'], 3); ?> DT
    </td>

    <td>
        <?php echo $produit['quantite']; ?>
    </td>

    <td>
        <b>
            <?php echo number_format($produit['prix'] * $produit['quantite'], 3); ?> DT
        </b>
    </td>

    <td>
        <a href="supprime.php?index=<?php echo $produit['index_original']; ?>">
            <button class="btn-delete">Supprimer</button>
        </a>
    </td>

</tr>

<?php endforeach; ?>

</table>

</div>

<div class="resume-box">

    <div class="resume-line">
        <span>Total HT</span>
        <span><?php echo number_format($total, 3); ?> DT</span>
    </div>

    <div class="resume-line">
        <span>Livraison</span>

        <?php if($livraison_finale == 0 && $total > 0): ?>

            <span class="livraison-gratuite">Gratuite 🎉</span>

        <?php else: ?>

            <span><?php echo number_format($livraison_finale, 3); ?> DT</span>

        <?php endif; ?>
    </div>

    <div class="resume-total">
        <span>Total à payer</span>
        <span><?php echo number_format($total_final, 3); ?> DT</span>
    </div>

    <br>

    <form method="POST" action="confirm.php">
        <button class="btn-confirm">Confirmer la commande</button>
    </form>

    <br>

    <form method="POST" action="vider_panier.php">
        <button class="btn-delete" style="width:100%;">
            Supprimer toute la commande
        </button>
    </form>

</div>

<?php endif; ?>

<?php include 'footer.php'; ?>

</body>
</html>