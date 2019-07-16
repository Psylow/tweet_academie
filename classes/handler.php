<?php
//Connexion simple à la BDD via PDO
try {
    $bdd = new PDO('mysql:dbname=common-database;host=localhost', 'root', 'root');
} catch (Exception $e) {
    die('Connexion échoué :' . $e->getMessage());
}

/**
 * On analyse la demande faite via la methode GET
 * afin de déterminer si ou souhaite réccupérer un msg
 * ou en écrire 1
 */

$task = "list";
if (array_key_exists("task", $_GET)) {
    $task = $_GET["task"];
}

if ($task == "write") {
    postMessages();
} else {
    getMessages();
}

/**
 * Si on veut récupérer on envoie du JSON
 */

function getMessages()
{
    global $bdd;
    //1. On requète la bdd pour sortir les 20 dernier msg
    $resultats = $bdd->query("SELECT * FROM messages ORDER BY message_date DESC LIMIT 20");
    //2. on traite les données
    $messages = $resultats->fetchAll();
    //3. on affiche les données sous form de Json
    echo json_encode($messages);
}

/**
 * Si on on veut écrire un msg, il faut analyser les 
 * paramètres envoyés en POST et les save dans la BDD
 */

function postMessages() {
    global $bdd;
    //1. analyser les parametre passé en post (author et content)

    if(array_key_exists('content',$_POST)) {
        echo json_encode(["status" => "error", "message" => "oulala y'a un soucis quelque part !"]);
        return;
    }

    // $author = $_POST["author"];
    $from = $_SESSION["pseudo"];
    $content = $_POST["content"];
    var_dump($_POST);

    //2. créer une requête qui permet d'inscérer les données en bdd
    $query = $bdd->query("INSERT INTO messages('from_id','message_content') VALUES '".$from."','".$content."'");
    
    //3. donner un statu succé ou erreur en json
    echo json_encode(["status" => "success"]);
}
