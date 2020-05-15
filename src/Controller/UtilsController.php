<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UtilsController extends AbstractController
{
    /**
     * @Route("/utils", name="utils")
     */
    public function whoIam()
    {
        return $this->render('utils/index.html.twig');
    }
}
