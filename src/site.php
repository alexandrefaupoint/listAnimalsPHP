<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/AnimalStorageStub.php");
require_once("PathInfoRouter.php");
require_once("model/AnimalStorageSession.php");
require_once("model/AnimalStorageMySQL.php");
require_once("model/lib.php");

session_start();
$pdo = connecter(); // Appelle la fonction pour créer une instance de PDO

if ($pdo === null) {
    die("Impossible de se connecter à la base de données.");
}

$storage =  new AnimalStorageMySQL($pdo);
$router = new PathInfoRouter();
$router->main($storage);
?>