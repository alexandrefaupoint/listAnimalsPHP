<?php
require_once("AnimalStorage.php");
require_once("Animal.php");
class AnimalStorageStub implements AnimalStorage {
    private $animalsTab;

    public function __construct() {
        $this -> animalsTab = array(
            'medor' => new Animal("Médor", "chien", 4),
            'felix' => new Animal('Félix', 'chat', 3),
            'denver' => new Animal('Denver', 'dinosaure', 2),
            'hector' => new Animal("Hector", "castor", 2),
            'bob' => new Animal("Bob Ross", "humain", 53),
        );
    }

    public function read($id) {
        // ?? pour un isset et returner animalsTab[$id] ou null sinon
        return $this -> animalsTab[$id] ?? null;
    }

    public function readAll() {
        return $this -> animalsTab;
    }

    public function create(Animal $id) {
        throw new Exception("Méthode pas encore faite");
    }

    public function delete($id) {
        throw new Exception("Méthode pas encore faite");
    }

    public function update($id, Animal $a) {
        throw new Exception("Méthode pas encore faite");
    }
}

?>