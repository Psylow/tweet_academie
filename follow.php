<?php
session_start();
var_dump($_POST);
try {
    $bdd = new PDO('mysql:dbname=common-database;host=localhost', 'root', 'root');
} catch (Exception $e) {
    die('Connexion échoué :' . $e->getMessage());
}
include('classes/profilMembre.class.php');
$user = new Membre($_SESSION['pseudo']);

/* La je vais chercher l'id de l'utilisateur que tu veut follow pour ma fonction */
$getProfilID = $bdd->prepare('select id from users where pseudo=?');
$getProfilID->execute(array($_POST['pseudo']));
$profilId = $getProfilID->fetch();

/* Vu que la bdd elle pu sa mère on est obliger de convertir l'ID en string */
$profilId['id'] = strval($profilId['id']);

$follow = $user->follow($profilId['id']);