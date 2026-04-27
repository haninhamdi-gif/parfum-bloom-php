<?php
session_start();

if(isset($_POST['id'])){

    $id = intval($_POST['id']);

    /* créer tableau favoris si n'existe pas */

    if(!isset($_SESSION['favoris'])){
        $_SESSION['favoris'] = [];
    }

    /* éviter doublons */

    if(!in_array($id, $_SESSION['favoris'])){
        $_SESSION['favoris'][] = $id;
    }

    /* rediriger vers page favoris */

    header("Location: favoris.php");
    exit();

}else{

    

    header("Location: index1.php");
    exit();

}
?>