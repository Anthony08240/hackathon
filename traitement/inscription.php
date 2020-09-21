<?php
include('connectbdd.php');

$mail = !empty($_POST['email']) ? $_POST['email'] : NULL;
$mdp = !empty($_POST['password']) ? $_POST['password'] : NULL;
$mdp2 = !empty($_POST['password-repeat']) ? $_POST['password-repeat'] : NULL;

$mailexiste = $bdd->prepare("SELECT mail FROM users WHERE mail = '$mail'");
$mailexiste->execute();

$count = $mailexiste->rowCount();
if($count==0) {

if($mdp == $mdp2) {

    $inscription = $bdd->prepare("INSERT INTO users (mail, mdp)
                                      VALUES (:mail, :mdp)");

    $inscription->execute(array(
    ':mail' => $mail,
    ':mdp' => $mdp
    ));

    header('location: ../inscription.php?success=1');
}else {
    header('location: ../inscription.php?success=2');
}
}else{
    header('location: ../inscription.php?success=3');
}
?>