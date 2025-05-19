<?php
class AnimalBuilder {
    private $data;
    private $error;
    public const NAME_REF = 'nom';
    public const SPECIES_REF = 'espece';
    public const AGE_REF = 'age';

    public function __construct(array $data) {
        $this->data = $data;
        $this->error = null;
    }

    public function getData(): array {
        return $this->data;
    }

    public function getError(): ?string {
        return $this->error;
    }

    public function setError(string $error): void {
        $this->error = $error;
    }

    public function createAnimal(): Animal {
        return new Animal(
            $this->data[self::NAME_REF],
            $this->data[self::SPECIES_REF],
            (int) $this->data[self::AGE_REF]
        );
    }

    public function isValid() {
        $this->errors = [];
        
        // Validation des données
        if (empty($this->data[self::NAME_REF])) {
            $this->errors[self::NAME_REF] = "Le nom ne peut pas être vide.";
        }
        if (empty($this->data[self::SPECIES_REF])) {
            $this->errors[self::SPECIES_REF] = "L'espèce ne peut pas être vide.";
        }
        if (empty($this->data[self::AGE_REF]) || !is_numeric($this->data[self::AGE_REF]) || $this->data[self::AGE_REF] <= 0) {
            $this->errors[self::AGE_REF] = "L'âge doit être un nombre positif.";
        }

        return empty($this->errors);
    }
}

?>