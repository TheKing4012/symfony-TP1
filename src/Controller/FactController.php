<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FactController extends AbstractController
{
    public static function fact($n)
    {
        if($n == 1) {
            return 1;
        } else {
            return $n * self::fact($n - 1);
        }
    }

    public static function combi($n, $p)
    {
        return self::fact($n) / (self::fact($p) * self::fact($n - $p));
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        // Récupérer les données du formulaire
        $factorielle = $request->query->get('factorielle');
        $n = $request->query->get('n');
        $p = $request->query->get('p');

        $response = $this->render('base.html.twig');
        // Effectuer le traitement nécessaire, par exemple :
        $text_result = null;
        if ($factorielle !== null) {
            $result = self::fact($factorielle);
            //$text_result = "Fact(".$factorielle.")=".$result;
            $response = $this->render('factocombi.html.twig', [
                'n' => $factorielle,
                'r' => $result
            ]);
        } elseif ($n !== null && $p !== null) {
            $result = self::combi($n, $p);
            //$text_result = "Combinaisons(" .$n.",".$p.")=".$result;
            $response = $this->render('factocombi.html.twig', [
                'n' => $n,
                'p' => $p,
                'r' => $result
            ]);
        }

        return $response;

        //VERSION MEME TWIG
        // Retourner la réponse avec le résultat
        /*return $this->render('base.html.twig', [
            'result' => $text_result
        ]);
        */

        //VERSION PLUSIEURS TWIG

    }

    //UTILISATION DU TWIG
    /*
    #[Route('/fact', name: 'fact')]
    public function index_fact(Request $request): Response
    {
        $n = $request->query->get('n'); //Recuperation du n donné via la méthode GET du formulaire
        $result = self::fact($n);
        $text_result = "Fact(" .$n.")=".$result;
        return $this->render('base.html.twig', [
            'result' => $text_result
        ]);
    }

    #[Route('/combi', name: 'combi')]
    public function index_combi(Request $request): Response
    {
        $n = $request->query->get('n');
        $p = $request->query->get('p');
        $result = self::combi($n, $p);
        $text_result = "Combinaisons(" .$n.",".$p.")=".$result;
        return $this->render('base.html.twig', [
            'result' => $text_result
        ]);
    }
    */

    //ENVOI VERS UNE PAGE A PART
    #[Route('/fact/{n<\d+>?1}', name: 'fact2')]
    public function index_fact2($n): Response
    {
        $result = self::fact($n);
        $text_result = "Fact(" .$n.")=".$result;
        return new Response($text_result);
    }

    #[Route('/combi/{n<\d+>?1}/{p<\d+>?1}', name: 'combi2')]
    public function index_combi2($n, $p): Response
    {
        $result = self::combi($n, $p);
        $text_result = "Combinaisons(" .$n.",".$p.")=".$result;
        return new Response($text_result);
    }

    //VERSION QUI ENVOIE VERS UNE PAGE A PART:
    /*
    #[Route('/fact', name: 'fact')]
    public function index_fact(Request $request): Response
    {
        $n = $request->query->get('n');
        return new Response(self::fact($n));
    }

    #[Route('/combi', name: 'combi')]
    public function index_combi(Request $request): Response
    {
        $n = $request->query->get('n');
        $p = $request->query->get('p');
        return new Response(self::combi($n, $p));
    }
    */
}
