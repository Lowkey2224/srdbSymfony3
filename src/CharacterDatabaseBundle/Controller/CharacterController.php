<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;


use CharacterDatabaseBundle\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends Controller
{

    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $chars = $repo->findAll();
        return $this->render('CharacterDatabaseBundle:Character:index.json.twig', ['characters' => $chars], new JsonResponse());
    }

    public function showAction($id){
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $char = $repo->find($id);
        return $this->render('CharacterDatabaseBundle:Character:show.json.twig', ['char' => $char], new JsonResponse());
    }
}