<?php
session_start();
if(isset($_POST['id'])){

    $id = intval($_POST['id']);

    /* Vérifier si favoris existe */

    if(isset($_SESSION['favoris'])){


        $index = array_search($id, $_SESSION['favoris']);


        if($index !== false){

            unset($_SESSION['favoris'][$index]);


            $_SESSION['favoris'] = array_values($_SESSION['favoris']);

        }

    }

}


header("Location: favoris.php");
exit();
?>