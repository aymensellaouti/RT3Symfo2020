<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/twig")
 */
class TwigController extends AbstractController
{
    /**
     * @Route("/heritage", name="heritage")
     */
    public function heritage() {
        return $this->render('twig/heritage.html.twig');
    }

    /**
     * @Route("/color", name="color")
     */
    function colorTable() {
        $tableau = [
            ['firstname' => 'aymen','lastname'=>'sellaouti', 'age'=>37],
            ['firstname' => 'bacem','lastname'=>'zarai', 'age'=>21],
            ['firstname' => 'eya','lastname'=>'abdelmoula', 'age'=>21],
        ];
        return $this->render('twig/color.html.twig', ['tab' => $tableau]);
    }

    /**
     * @Route("/{nb?5}", name="twig")
     */
    public function index($nb)
    {
        $tab = [];
        for ($i=0;$i<$nb;$i++) {
            $tab[]=mt_rand(1,1000);
        }
        return $this->render('twig/index.html.twig', [
            'tableau' => $tab,
        ]);
    }
}
