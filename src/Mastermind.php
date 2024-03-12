<?php

namespace App;

class Mastermind implements iMastermind
{
    private int $codeSecret;
    private $taille;
    private $essais;

    public function __construct($taille = 4)
    {
        $this->taille = $taille;
        $this->codeSecret = $this->generateSecretCode();
        $this->essais = [];
    }

    public function test($code) {
        // Vérifier si le code proposé est valide (par exemple, s'assurer qu'il contient uniquement des chiffres et qu'il a la bonne longueur)
        if (!$this->validerCode($code)) {
            throw new \InvalidArgumentException("Le code proposé n'est pas valide.");
        }

        // Récupérer le code secret
        $secretCode = $this->getCodeSecret();

        // Initialiser les compteurs
        $wellPlaced = 0;
        $wrongPlace = 0;

        // Comparer chaque chiffre du code proposé avec le code secret
        for ($i = 0; $i < $this->taille; $i++) {
            if (substr($code, $i, 1) == substr($secretCode, $i, 1)) {
                $wellPlaced++;
            } else {
                $wrongPlace++;
            }
        }

        // Ajouter les résultats à la liste des essais
        $this->essais[] = [
            'code' => $code,
            'wellPlaced' => $wellPlaced,
            'wrongPlace' => $wrongPlace
        ];
    }

    private function validerCode($code) {
        // Vérifier si le code a la bonne longueur
        if (strlen($code) !== $this->taille) {
            return false;
        }

        // Vérifier si le code ne contient que des chiffres
        if (!ctype_digit($code)) {
            return false;
        }

        // Le code est valide
        return true;
    }

    public function getEssais()
    {
        return $this->essais;
    }

    public function getTaille()
    {
        return $this->taille;
    }

    public function getCodeSecret()
    {
        return $this->codeSecret;
    }

    public function isFini() {
        // Si le nombre de tentatives est égal à zéro, le jeu n'est pas terminé
        if (count($this->essais) === 0) {
            return false;
        }

        // Récupérer la dernière tentative
        $derniereTentative = end($this->essais);

        // Vérifier si tous les chiffres de la dernière tentative sont bien placés
        if ($derniereTentative['wellPlaced'] === $this->taille) {
            return true; // Tous les chiffres sont bien placés, le jeu est terminé
        }

        return false; // Le jeu n'est pas terminé
    }

    private function generateSecretCode(): string
    {
        return "".rand(1000,9999);
    }

    public function serialize()
    {
        return serialize([
            'codeSecret' => $this->codeSecret,
            'taille' => $this->taille
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->codeSecret = $data['codeSecret'];
        $this->taille = $data['taille'];
    }
}