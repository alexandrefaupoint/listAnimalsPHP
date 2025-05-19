<?php
interface AnimalStorage {
    public function read($id);
    public function readAll();

    /**
     * Ajoute un animal
     * @param Animal $id l'animal à ajouter
     * @return String l'identifiant de l'animal créé
     */
    public function create(Animal $id);

    /**
     * Supprime un animal
     * @param String l'identifiant de l'animal à supprimer
     * @return bool true si la suppression a été faite, false sinon
     */
    public function delete($id);

    /**
     * Mise à jour d'un animal
     * @param String $id l'identifiant de l'animal à mettre à jour
     * @param Animal $identifiant Les informations de l'animal mises à jour
     * @return bool true si l'update est réussi, false sinon.
     */
    public function update($id, Animal $identifant);

}
?>