<?php
session_start();
include('connectbdd.php');

$mail = $_POST['email'];
$mdp = $_POST['password'];

$connexion = $bdd->prepare("SELECT mail, mdp FROM users WHERE mail = :mail AND mdp = :mdp");
$connexion->execute(array(
    'mail' => $mail,
    'mdp' => $mdp
));

$resultat = $connexion->fetch();
$nbresultats = $connexion->rowCount();

if ($nbresultats == 1) {

    $_SESSION['mail'] = $resultat['mail'];

    header('location: ../index.php?success=1');
} else {
    header('location: ../index.php?success=2');
}



?>