<?php

namespace App\Controller;

use App\Form\StudentsLoaderType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
        dd($request);
        return new Response('cc');
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

    /**
     * @Route("", name="xlsx")
     */
    public function xlsx(Request $request) {
        $form = $this->createForm(StudentsLoaderType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            dump($form['section']->getData());
            $fileFolder = __DIR__.'/../../public/files/';
            $filePathName = md5(uniqid()).$file->getClientOriginalName();
            try {
                $file->move($fileFolder, $filePathName);
            } catch (FileException $e) {
                dd($e);
            }
            $spreadsheet = IOFactory::load($fileFolder.$filePathName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            dd($sheetData);
        }
        return $this->render('personne/load.html.twig', array(
            'form' => $form->createView()
        ) );
    }
}
