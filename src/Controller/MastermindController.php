<?php

namespace App\Controller;

use App\Mastermind;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\iMastermind;

class MastermindController extends AbstractController
{
    #[Route('/master', name: 'app_mastermind')]
    public function play(Request $request, SessionInterface $session): Response
    {
        // Récupérer ou créer une instance de Mastermind depuis la session
        $mastermind = $session->get('mastermind');
        if (!$mastermind) {
            $mastermind = new Mastermind();
            $session->set('mastermind', $mastermind);
        }

        // Récupérer les données du formulaire
        $code = $request->request->get('code');

        // Tester la proposition de code
        $mastermind->test($code);

        // Récupérer les résultats
        $results = $mastermind->getEssais();

        // Vérifier si le jeu est terminé
        if ($mastermind->isFini()) {
            // Réinitialiser le jeu
            $mastermind = new Mastermind();
            $session->set('mastermind', $mastermind);
        }

        return $this->render('mastermind/play.html.twig', [
            'results' => $results
        ]);
    }
}
