<?php
class View {
    public $title;
    public $content;
    public $router;
    public $menu;
    public $feedback;

    public function __construct($router, $feedback='') {
        $this -> router = $router;
        $this -> menu = [
            $this -> router -> getAnimalUrl("") => "Accueil",
            $this -> router -> getAnimalUrl("liste") => "Liste des animaux"
        ];
        $this->feedback = $feedback;
    }

    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }

    public function renderHeader() {
        if (!empty($this->feedback)) {
            return "<p style='color: green; font-weight: bold;'>$this->feedback</p>";
        }
        return "";
    }

    public function render()  {
        echo "<!doctype html>
        <html lang='fr'>
        <head>
        <meta charset='utf-8'>
            <title>{$this -> title}</title>
        </head>
        <body>
            <nav>
                <ul>";
                    foreach($this->menu as $url => $text) {
                        echo "<li><a href='{$url}'>{$text}</a></li>";
                    }
                    echo " </ul>
                    </nav>";
                    echo $this->renderHeader();
                    echo "<h1>{$this->title}</h1>
                    <div>{$this->content}</div>
        </body>
        </html>";
    }

    public function prepareTestPage() {
        $this -> title = "Page de test";
        $this -> content = "Ceci est une page de test";
    }

    public function prepareAnimalPage(Animal $animal) {
        //On échappe les infos
        $escapedName = htmlspecialchars($animal->getName(), ENT_QUOTES, 'UTF-8');
        $escapedSpecies = htmlspecialchars($animal->getSpecies(), ENT_QUOTES, 'UTF-8');
        $escapedAge = htmlspecialchars($animal->getAge(), ENT_QUOTES, 'UTF-8');
        
        $this->title = "Page sur " . $escapedName;
        $this->content = $escapedName . " est de l'espèce " . $escapedSpecies . " et a " . $escapedAge . " ans";
    }

    public function prepareUnknownAnimalPage() {
        $this -> title = "Animal inconnu";
        $this -> content = "Espèce inconnu";
    }

    public function preparehomePage() {
        $this -> title = "Accueil";
        $this -> content = "Voici mon site"; 
    }

    public function prepareListPage($animals) {
        $this->title = "Liste des animaux";
        $this->content = "<ul>";
        foreach ($animals as $id => $animal) {
            $url = $this->router->getAnimalUrl($id);
            //On échappe le nom
            $safeName = htmlspecialchars($animal->getName(), ENT_QUOTES, 'UTF-8');
            $this->content .= "<li><a href='{$url}'>{$safeName}</a></li>";
        }
        $this->content .= "</ul>";
    }

    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function prepareAnimalCreationPage(AnimalBuilder $builder) {
        // Récupération des valeurs à partir de l'instance d'AnimalBuilder
        $data = $builder->getData(); // Récupère les données
        $errors = $builder->getError(); // Récupère les erreurs de validation
    
        // Encodage des données pour éviter les failles XSS
        $nameValue = htmlspecialchars($data[AnimalBuilder::NAME_REF] ?? '', ENT_QUOTES, 'UTF-8');
        $speciesValue = htmlspecialchars($data[AnimalBuilder::SPECIES_REF] ?? '', ENT_QUOTES, 'UTF-8');
        $ageValue = htmlspecialchars($data[AnimalBuilder::AGE_REF] ?? '', ENT_QUOTES, 'UTF-8');
    
        $this->title = "Créer un nouvel animal";
        
        // Construction du formulaire
        $this->content = "
            <form method='POST' action='" . $this->router->getAnimalSaveURL() . "'>
                <label for='" . AnimalBuilder::NAME_REF . "'>Nom :</label>
                <input type='text' id='" . AnimalBuilder::NAME_REF . "' name='" . AnimalBuilder::NAME_REF . "' value='$nameValue' required>
                " . ($errors[AnimalBuilder::NAME_REF] ?? '') . "<br>
    
                <label for='" . AnimalBuilder::SPECIES_REF . "'>Espèce :</label>
                <input type='text' id='" . AnimalBuilder::SPECIES_REF . "' name='" . AnimalBuilder::SPECIES_REF . "' value='$speciesValue' required>
                " . ($errors[AnimalBuilder::SPECIES_REF] ?? '') . "<br>
    
                <label for='" . AnimalBuilder::AGE_REF . "'>Âge :</label>
                <input type='number' id='" . AnimalBuilder::AGE_REF . "' name='" . AnimalBuilder::AGE_REF . "' value='$ageValue' required>
                " . ($errors[AnimalBuilder::AGE_REF] ?? '') . "<br>
    
                <button type='submit'>Créer</button>
            </form>
        ";
    
        if (!empty($errors)) {
            $this->content = "<p style='color: red;'>Veuillez corriger les erreurs ci-dessus.</p>" . $this->content;
        }
    }

    public function displayAnimalCreationSuccess($id) {
        $url = $this->router->getAnimalUrl($id);
        $_SESSION['feedback'] = "Animal créé avec succès";
        $this->router->POSTredirect($url, "Animal créé avec succès");
    }
    
}


?>