<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Personne;
use App\Entity\SocialMedia;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
     * @Route("/addFake", name="personne.fake.add")
     */
    function addFakePersonne(EntityManagerInterface $manager) {
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

    /**
     * @Route("/add/{id?0}", name="personne.add")
     */
    public function addPersonne(Request $request, Personne $personne=null, EntityManagerInterface $manager) {
        if (! $personne) {
            $personne = new Personne();
        }
        $form = $this->createForm(PersonneType::class, $personne);
        $form->remove('socialMedia');
        $form->remove('path');
        //$formView = $form->createView();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form['image']->getData();
            $imgPath = md5(uniqid()).$image->getClientOriginalName();

            $destination = __DIR__.'\..\..\public\assets\uploads';
            $personne->setPath("assets\uploads\$imgPath");
            try {
                $image->move($destination, $imgPath);
            } catch (FileException $e) {
                dd($e);
            }
            $manager->persist($personne);
            $manager->flush();
            return $this->redirectToRoute('personne');
            // Ajouter cette personne dans la base de données
        }
        return $this->render('personne/add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
