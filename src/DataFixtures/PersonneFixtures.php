<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $faker = Factory::create('fr_FR');
         for($i=0; $i<100; $i++) {
             $personne = new Personne();
             $personne->setName($faker->name);
             $personne->setFirstname($faker->firstName);
             $personne->setAge($faker->numberBetween(18,70));
             $personne->setCin($faker->numberBetween(100, 111111));
             $personne->setPath($faker->imageUrl($width = 640, $height = 480));
             $manager->persist($personne);
         }
        $manager->flush();
    }
}
