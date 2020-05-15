<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TodoController
 * @package App\Controller
 * @Route("/todo")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="todo")
     */
    public function index(SessionInterface $session)
    {
        // Todo
        /*
         * Vérifier si premiere visite ou non
         * Si oui je la remplie avec les fakes todo
         * Sinon je l'affiche
         * */
        if (!$session->has('todos')) {
            $session->set('todos', array(
                'lundi' => 'Travailler',
                'Mercredi' => 'Faire du sport'
            ));
            $this->addFlash('welcome', 'Bienvenu Dans la liste des todos');
        }
        return $this->render('todo/index.html.twig');
    }

    /**
     * @Route("/add/{title}/{content?me reposer}", name="todo.add")
     */
    public function addUpdateTodo(Request $request, $title, $content) {
        $session = $request->getSession();
        /*
         * est ce que j'ai deja une session
         *      si oui
         *          je vérifie est ce que ajout ou mise à jour
         *              Si ajout flash Ajout
         *              sinon flash update
         *      sinon
         *          redirection avec message erreur
         * */
        if (!$session->has('todos')) {
            $this->addFlash('error', 'Vous devez toujours commencer par la page index');
        } else {
            $todos = $session->get('todos');
            if (isset($todos[$title])) {
                $this->addFlash('success', "Todo $title mis à jour avec succès");
            } else {
                $this->addFlash('success', "Todo $title ajouté avec succès");
            }
            $todos[$title]=$content;
            $session->set('todos', $todos);
            return $this->redirectToRoute("todo");
        }
    }
    /**
     * @Route("/delete/{title}", name="todo.delete")
     */
    public function deleteTodo(Request $request, $title) {
        $session = $request->getSession();
        /*
         * est ce que j'ai deja une session
         *      si oui
         *          je vérifie est ce que ajout ou mise à jour
         *              Si ajout flash Ajout
         *              sinon flash update
         *      sinon
         *          redirection avec message erreur
         * */
        if (!$session->has('todos')) {
            $this->addFlash('error', 'Vous devez toujours commencer par la page index');
        } else {
            $todos = $session->get('todos');
            if (isset($todos[$title])) {
                $this->addFlash('success', "Todo $title supprimé avec succès");
                unset($todos[$title]);
            } else {
                $this->addFlash('error', "Todo $title n'existe pas");
            }
            $session->set('todos', $todos);
            return $this->redirectToRoute("todo");
        }
    }
}
