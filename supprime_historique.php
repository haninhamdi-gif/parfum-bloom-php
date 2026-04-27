<?php
session_start();

require_once "config/Database.php";

$database = new Database();
$db = $database->getConnection();


if(isset($_POST['commande_id'])){

    $commande_id = intval($_POST['commande_id']);

    try{


        $db->beginTransaction();


        $sqlArticles = "
        DELETE FROM commande_articles
        WHERE commande_id = :commande_id
        ";

        $stmtArticles = $db->prepare($sqlArticles);

        $stmtArticles->execute([
            ':commande_id' => $commande_id
        ]);


        $sqlCommande = "
        DELETE FROM commandes
        WHERE id = :commande_id
        ";

        $stmtCommande = $db->prepare($sqlCommande);

        $stmtCommande->execute([
            ':commande_id' => $commande_id
        ]);

        

        $db->commit();

    }

    catch(Exception $e){

        $db->rollBack();

        echo "Erreur suppression : ".$e->getMessage();
        exit();

    }

}


header("Location: historique.php");

exit();
?>