<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'admin'
){
    header("Location: index1.php");
    exit();
}

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

$message = "";



if(isset($_POST['ajouter'])){

    $nom = $_POST['nom'];
    $prix50 = $_POST['prix50'];
    $categorie_id = $_POST['categorie_id'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if(!empty($image)){

        move_uploaded_file($tmp,"images/".$image);

        $sql = "INSERT INTO parfums
        (nom, prix50, image, categorie_id)
        VALUES (?, ?, ?, ?)";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            $nom,
            $prix50,
            $image,
            $categorie_id
        ]);

        $message="Parfum ajouté ✔";

    }
}



if(isset($_GET['supprimer'])){

$id=intval($_GET['supprimer']);

$sql="DELETE FROM parfums WHERE id=?";
$stmt=$db->prepare($sql);

$stmt->execute([$id]);

header("Location: admin.php");
exit();

}



$sql="SELECT * FROM parfums ORDER BY id DESC";
$stmt=$db->prepare($sql);
$stmt->execute();

$parfums=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>Admin</title>

<style>

body{
margin:0;
font-family:Arial;
background:white;
}

.header{
background:black;
color:white;
padding:18px 40px;
border-bottom:4px solid #7a1f2b;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
font-size:22px;
font-weight:bold;
color:#ffd6de;
}

.btn{
background:#7a1f2b;
color:white;
padding:10px 20px;
text-decoration:none;
border-radius:25px;
font-weight:bold;
}

.container{
width:90%;
max-width:1000px;
margin:40px auto;
}

h2{
text-align:center;
color:#7a1f2b;
}

.form-box{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 8px 22px rgba(0,0,0,0.12);
margin-bottom:40px;
}

input, select{
width:100%;
padding:12px;
margin:10px 0;
border-radius:8px;
border:1px solid #ccc;
}

button{
width:100%;
padding:12px;
background:#7a1f2b;
color:white;
border:none;
border-radius:25px;
font-weight:bold;
cursor:pointer;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#7a1f2b;
color:white;
padding:12px;
}

td{
padding:12px;
text-align:center;
border-bottom:1px solid #eee;
}

img{
width:60px;
height:70px;
object-fit:contain;
}

.delete{
background:red;
color:white;
padding:6px 12px;
border-radius:20px;
text-decoration:none;
}

.message{
text-align:center;
color:green;
font-weight:bold;
}

</style>

</head>

<body>

<div class="header">

<div class="logo">
Admin Panel
</div>

<a href="index1.php" class="btn">
Retour site
</a>

</div>

<div class="container">

<h2>Ajouter parfum</h2>

<p class="message">
<?php echo $message; ?>
</p>

<div class="form-box">

<form method="POST" enctype="multipart/form-data">

<input type="text"
name="nom"
placeholder="Nom parfum"
required>

<input type="number"
step="0.01"
name="prix50"
placeholder="Prix"
required>

<select name="categorie_id" required>

<option value="">Choisir catégorie</option>

<option value="1">
Parfum Homme
</option>

<option value="2">
Parfum Femme
</option>

</select>

<input type="file"
name="image"
required>

<button name="ajouter">
Ajouter parfum
</button>

</form>

</div>

<h2>Liste parfums</h2>

<table>

<tr>

<th>ID</th>
<th>Image</th>
<th>Nom</th>
<th>Prix</th>
<th>Action</th>

</tr>

<?php foreach($parfums as $p): ?>

<tr>

<td>
<?php echo $p['id']; ?>
</td>

<td>
<img src="images/<?php echo $p['image']; ?>">
</td>

<td>
<?php echo $p['nom']; ?>
</td>

<td>
<?php echo $p['prix50']; ?> DT
</td>

<td>

<a class="delete"
href="admin.php?supprimer=<?php echo $p['id']; ?>"
onclick="return confirm('Supprimer ?');">

Supprimer

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>

</html>