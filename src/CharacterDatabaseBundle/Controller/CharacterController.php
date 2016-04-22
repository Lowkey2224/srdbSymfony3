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
}