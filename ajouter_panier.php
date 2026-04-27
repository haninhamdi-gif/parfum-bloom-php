<?php
session_start();

/* Connexion PostgreSQL */
$conn = pg_connect("host=localhost port=5433 dbname=parfum user=postgres password=hanin123");

if(!$conn){
    die("Erreur connexion PostgreSQL");
}

/* Créer panier si n'existe pas */
if(!isset($_SESSION['panier'])){
    $_SESSION['panier'] = array();
}

/* Vérifier id */
if(isset($_POST['id'])){

    $id = intval($_POST['id']);
    $type = isset($_POST['type']) ? $_POST['type'] : "parfum";
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1;

    /* CAS PARFUM */
    if($type == "parfum"){

        if(!isset($_POST['ml'])){
            header("Location: index1.php");
            exit;
        }

        $ml = intval($_POST['ml']);

        $sql = "SELECT * FROM parfums WHERE id = $1";
        $result = pg_query_params($conn, $sql, array($id));

        if(!$result){
            die("Erreur requête parfum : ".pg_last_error($conn));
        }

        $produit = pg_fetch_assoc($result);

        if(!$produit){
            die("Parfum introuvable");
        }

        if($ml == 50){
            $prix = $produit['prix50'];
        }
        elseif($ml == 80){
            $prix = $produit['prix80'];
        }
        else{
            $prix = $produit['prix100'];
        }

        for($i = 0; $i < $quantite; $i++){

            $_SESSION['panier'][] = array(
                "id" => $produit['id'],
                "type" => "parfum",
                "nom" => $produit['nom'],
                "image" => $produit['image'],
                "ml" => $ml,
                "prix" => $prix
            );

        }

    }

    /* CAS COFFRET */
    elseif($type == "coffret"){

        $sql = "SELECT * FROM coffrets WHERE id = $1";
        $result = pg_query_params($conn, $sql, array($id));

        if(!$result){
            die("Erreur requête coffret : ".pg_last_error($conn));
        }

        $produit = pg_fetch_assoc($result);

        if(!$produit){
            die("Coffret introuvable");
        }

        for($i = 0; $i < $quantite; $i++){

            $_SESSION['panier'][] = array(
                "id" => $produit['id'],
                "type" => "coffret",
                "nom" => $produit['nom'],
                "image" => $produit['image'],
                "ml" => "",
                "prix" => $produit['prix']
            );

        }

    }

    header("Location: panier.php");
    exit;

}else{

    header("Location: index1.php");
    exit;

}
?>
