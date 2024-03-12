<?php
// src/Controller/FaviconController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class FaviconController
{
    public function index(): Response
    {
        // Renvoyer une réponse avec l'icône de favicon
        // Vous pouvez remplacer le chemin par celui de votre fichier favicon.ico
        return new Response(file_get_contents('favicon.ico'), 200, ['Content-Type' => 'image/x-icon']);
    }
}