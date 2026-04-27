<?php
session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nom, email, password) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);

    try {

        $stmt->execute([$nom, $email, $password_hash]);

        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_nom'] = $nom;

        header("Location: index1.php");
        exit();

    } catch (PDOException $e) {

        $message = "Email déjà utilisé.";

    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Inscription</title>

<style>

html, body{
    height:100%;
    margin:0;
}

body{
    font-family:Arial, sans-serif;
    background:white;
    display:flex;
    flex-direction:column;
    min-height:100vh;
}

/* HEADER */

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
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.menu-btn:hover{
    background:#a52a3a;
}

/* CONTENU */

.main-content{
    flex:1;
}

.form-box{
    width:380px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    border:1px solid #eee;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
}

h2{
    text-align:center;
    color:#7a1f2b;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
}

input:focus{
    outline:none;
    border-color:#7a1f2b;
}

button{
    width:100%;
    padding:12px;
    background:#7a1f2b;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#a52a3a;
}

a{
    color:#7a1f2b;
    text-decoration:none;
    font-weight:bold;
}

.message{
    color:red;
    text-align:center;
}

footer{
    margin-top:auto;
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

    </div>

</div>

<!-- CONTENU PRINCIPAL -->

<div class="main-content">

    <div class="form-box">

        <h2>Inscription</h2>

        <p class="message">
            <?php echo $message; ?>
        </p>

        <form method="POST">

            <input type="text" name="nom" placeholder="Nom" required>

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Mot de passe" required>

            <button type="submit">
                Créer mon compte
            </button>

        </form>

        <p style="text-align:center;">
            Déjà un compte ?
            <a href="login.php">Se connecter</a>
        </p>

    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>