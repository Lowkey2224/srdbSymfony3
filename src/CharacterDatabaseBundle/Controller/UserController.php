<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * Action route <i>user_show</i> with URL: <i>
     * @param $id
     */
    public function showAction($id){
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User');
        $user = $repo->find($id);

        return new JsonResponse($user);
//        return $this->render('CharacterDatabaseBundle:Character:show.json.twig', ['user' => $user], new JsonResponse());
    }
}