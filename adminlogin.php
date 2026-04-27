<?php
session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin && password_verify($password, $admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom'];
        header("Location: admin.php");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin - Connexion</title>
<style>
body{
    margin:0;
    font-family:Arial;
    background:#1a1a1a;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
}
.box{
    background:white;
    padding:40px;
    border-radius:16px;
    width:380px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}
h2{
    color:#7a1f2b;
    text-align:center;
    margin-bottom:25px;
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
    padding:13px;
    background:#7a1f2b;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:bold;
    font-size:16px;
    cursor:pointer;
    margin-top:10px;
}
button:hover{ background:#a52a3a; }
.message{ color:red; text-align:center; margin-bottom:10px; }
</style>
</head>
<body>
<div class="box">
    <h2>🔐 Admin - Bloom</h2>
    <?php if($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email admin" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>