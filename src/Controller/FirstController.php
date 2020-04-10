<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $response = new Response();
        $response->setContent('<h1>Hello RT3</h1>');
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
}
