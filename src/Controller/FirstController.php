<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function index(Request $request)
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }
    /**
     * @Route("/second", name="second")
     */
    public function second() {
        return $this->render('first/second.html.twig');
    }

    /**
     * @Route("/bonjour/{firstname}/{name}")
     */
    public function bonjour(Request $request, $name, $firstname) {
        if($request->query->get('test')) {
            dd($request->query->get('test'));
        }
        if($request->isXmlHttpRequest()) {
            $jsonResponse = new JsonResponse();
            $jsonResponse->setContent(['message' => 'hello']);
            return $jsonResponse;
        }
        return $this->render('first/bonjour.html.twig',[
            'esm' => $firstname,
            'la9ab' => $name
        ]);
    }
}
