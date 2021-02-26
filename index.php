<?php

/**
 * Reprenez le code de l'exercice précédent et transformez vos requêtes pour utiliser les requêtes préparées
 * la méthode de bind du paramètre et du choix du marqueur de données est à votre convenance.
 */

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data);
    return $data;
}

function issetPostParams(string ...$params): bool
{
    foreach ($params as $param) {
        if (!isset($_POST[$param])) {
            return false;
        }
    }
    return true;
}

if (issetPostParams('nom', 'prenom', 'email', 'password', 'adresse', 'code_postal', 'pays', 'date_join')) {


    try {
        $server = 'localhost';
        $user = 'root';
        $password = '';
        $db = 'table_test_php';

        $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $password);

        $stm = $pdo->prepare("
        INSERT INTO utilisateur('nom', 'prenom', 'email', 'password', 'adresse', 'code_postal', 'pays', 'date_join')
        VALUES (:nom,:prenom,:email,:password,:adresse,:code_postal,:pays,:date_join)
        ");

        $stm->execute([
        ":nom" => sanitize($_POST['nom']),
        ":prenom" => sanitize($_POST['prenom']),
        ":email" => sanitize($_POST['email']),
        ":password" => sanitize($_POST['password']),
        ":adresse" => sanitize($_POST['adresse']),
        ":code_postal" => sanitize($_POST['code_postal']),
        ":pays" => sanitize($_POST['pays']),
        ":date" => sanitize($_POST['date_join']),
        ]);

        echo "utilisateur ajouté !!";

    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage() . "<br>";
        $pdo->rollBack();
    }
}


