<?php
session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['role'] = $user['role'];

        header("Location: index1.php");
        exit();

    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion</title>

<style>
html, body{
    height:100%;
    margin:0;
}

body{
    font-family:Arial;
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

/* MAIN */

.main-content{
    flex:1;
}

.form-box{
    width:380px;
    margin:100px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
}

h2{
    color:#7a1f2b;
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
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

.message{
    color:red;
    text-align:center;
}

/* FOOTER */

footer{
    background:black;
    color:white;
    text-align:center;
    padding:35px 20px;
    margin-top:auto;
    border-top:4px solid #7a1f2b;
}

footer h3{
    margin-bottom:15px;
}

footer p{
    margin:8px 0;
}
</style>
</head>

<body>

<div class="header">

    <div class="logo">
        Bloom by islem
    </div>

    <div class="menu">

        <a href="index1.php" class="menu-btn">
            Accueil
        </a>

        <a href="#contact" class="menu-btn">
            Contact
        </a>

    </div>

</div>

<div class="main-content">

    <div class="form-box">

        <h2>Connexion</h2>

        <p class="message"><?php echo $message; ?></p>

        <form method="POST">

            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Mot de passe" required>

            <button type="submit">
                Se connecter
            </button>

        </form>

        <p style="text-align:center;">
            Pas encore de compte ?
            <a href="inscription.php" style="color:#7a1f2b;font-weight:bold;text-decoration:none;">
                Créer un compte
            </a>
        </p>

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