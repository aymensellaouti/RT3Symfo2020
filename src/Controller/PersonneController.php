<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Personne;
use App\Entity\SocialMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonneController
 * @package App\Controller
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne")
     */
    public function index(Request $request)
    {
        $numPage = $request->query->get('page') ?? 1;
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $nbEnregistrement = $repository->count(array());

        $personnes = $repository->findBy( array(), array ('id'=>'ASC') , 10, ($numPage - 1) * 10 );
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbPage' => ($nbEnregistrement / 10) + 1
        ]);
    }

   /**
     * @Route("/filter/{min}/{max}", name="personne.age.filter")
     */
    public function listeByAge(Request $request, $min, $max)
    {
        $numPage = $request->query->get('page') ?? 1;

        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $nbEnregistrement = $repository->count(array());
        $personnes = $repository->findPersonneByAgeInterval($min,$max);
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbPage' => ($nbEnregistrement / 10) + 1
        ]);
    }

    /**
     * @Route("/delete/{id}", name="personne.delete")
     */
    public function deletePersonne(Personne $personne=null) {
//        $repository = $this->getDoctrine()->getRepository(Personne::class);
//        $personne = $repository->find($id);
        if($personne) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', "Personne supprimée avec succès" );
        } else {
            $this->addFlash('error', "Personne innexistant" );
        }
        return $this->forward('App\\Controller\\PersonneController::index');
    }

    /**
     * @Route("/add", name="personne.add")
     */
    function addPersonne(EntityManagerInterface $manager) {
        $personne = new Personne();
        $personne->setAge('30');
        $personne->setPath('path');
        $personne->setCin('123457');
        $personne->setName('Test');
        $personne->setFirstname('Test');
        $socialMedia = new SocialMedia();
        $socialMedia->setFb('FaceBook 2');
        $socialMedia->setLinkedIn('LinkedIn 2');

        $cours = new Cours();
        $cours->setDesignation('Cours 1');
        $cours2 = new Cours();
        $cours2->setDesignation('Cours 2');
        $manager->persist($cours);
        $manager->persist($cours2);
        $classe = new Classe();
        $classe->setDesignation('classe 2');
        $manager->persist($classe);
        $manager->persist($socialMedia);
        $personne->setClasse($classe);
        $personne->setSocialMedia($socialMedia);
        $personne->addCour($cours);
        $personne->addCour($cours2);
        $manager->persist($personne);


        $manager->flush();

        return $this->forward('App\\Controller\\PersonneController::index');

    }
}
