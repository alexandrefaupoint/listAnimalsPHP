<?php
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/AnimalStorage.php");

class Router {

    public function main(AnimalStorage $storage) {
        $view = new View($this);
        $controller = new Controller($view, $storage);
        
        if(isset($_GET['action']) && $_GET['action'] === 'liste') {
            $controller -> showList();
        } elseif (isset($_GET['id'])) {
            $controller -> showInformation($_GET['id']);
        } else {
            $controller -> showHomePage();
        }
        $view -> render();
    }

    public function getAnimalUrl($id) {
        return "site.php?id=" . urlencode($id);
    }
}
?>