<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('area', [$this, 'calculateArea']),
            new TwigFunction('randomName' , [$this, 'getRandomName'])
            ];
    }

    public function calculateArea(int $width, int $length)
    {
        return $width * $length;
    }

    public function getRandomName() {
        return ('Bonjour');
    }
}
