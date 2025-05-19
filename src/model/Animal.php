<?php
class Animal {
    private $nom;
    private $species;
    private $age;

    public function __construct($nom, $species, $age) {
        $this -> nom = $nom;
        $this -> species = $species;
        $this -> age = $age;
    }

    public function getName() {
        return $this->nom;
    }

    public function getSpecies() {
        return $this -> species;
    }

    public function getAge() {
        return $this -> age;
    }

}

?>