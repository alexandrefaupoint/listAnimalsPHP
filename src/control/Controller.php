<?php

require_once('model/Animal.php');
require_once('model/AnimalBuilder.php');

class Controller {
    private $view;
    private $storage;
    private $router;

    public function __construct($view, $storage, $router) {
        $this -> view = $view;
        $this -> storage = $storage;
        $this -> router = $router;

    }

    public function showInformation($id) {
        $animal = $this -> storage -> read($id);
        if($animal) {
            $this -> view -> prepareAnimalPage($animal);

        } else {
            $this -> view -> prepareUnknownAnimalPage();
        }
    }

    public function showHomePage() {
        $this -> view -> prepareHomePage();
    }

    public function showList() {
        $this->view->prepareListPage($this -> storage -> readAll());
    }

    public function createNewAnimal() {
        $builder = new AnimalBuilder([]);
        $this->view->prepareAnimalCreationPage($builder);
    }

    public function saveNewAnimal(array $data) {
        $builder = new AnimalBuilder($data);
    
        // Validation des données
        if ($builder->isValid()) {
            $animal = $builder->createAnimal();
            $id = $this->storage->create($animal);
    
            // Message de succès
            $feedback = "L'animal a été créé avec succès.";
    
            // Redirection avec feedback
            $url = $this->router->getAnimalUrl($id);  // Générer l'URL de l'animal
            $this->router->POSTredirect($url, $feedback);  // Redirection avec feedback
        } else {
            // Message d'erreur si les données sont invalides
            $feedback = "Une erreur est survenue lors de la création de l'animal.";
    
            // Préparer la page de création avec les erreurs
            $this->view->setFeedback($feedback);  // Passer le feedback à la vue
            $this->view->prepareAnimalCreationPage($builder);  // Préparer la page de création
            $this->view->render();  // Afficher la page avec les erreurs
        }
    }


    
    
}

?>