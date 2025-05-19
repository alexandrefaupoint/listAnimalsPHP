<?php
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/AnimalStorage.php");

class PathInfoRouter {
    private $basePath;

    public function __construct() {
        // Chemin de base de l'application
        $this->basePath = "/TW4-2025/groupe-21/src/";
    }

    public function main(AnimalStorage $storage) {
        $feedback = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : '';
        $view = new View($this, $feedback);
        $controller = new Controller($view, $storage, $this);
    
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'nouveau') {
                $controller->createNewAnimal();
            } elseif ($action === 'sauverNouveau') {
                $controller->saveNewAnimal($_POST);
            } else {
                $controller->showHomePage();
            }
        } elseif (isset($_SERVER['PATH_INFO'])) {
            $path = trim($_SERVER['PATH_INFO'], '/');
            if ($path === 'liste') {
                $controller->showList();
            } elseif ($path) {
                $controller->showInformation($path);
            } else {
                $controller->showHomePage();
            }
        } else {
            $controller->showHomePage();
        }
    
        $view->render();
        unset($_SESSION['feedback']);
    }

    public function getAnimalUrl($id) {
        // Génère des URL absolues basées sur le chemin de base
        return $this->basePath . "site.php/" . urlencode($id);
    }

    public function getAnimalCreationURL() {
        return "site.php?action=nouveau";
    }
    
    public function getAnimalSaveURL() {
        return "site.php?action=sauverNouveau";
    }

    public function POSTredirect($url, $feedback) {
        // Stocker le feedback dans la session avant la redirection
        $_SESSION['feedback'] = $feedback;
        header("Location: $url", true, 303);
        exit();
    }
}
?>
