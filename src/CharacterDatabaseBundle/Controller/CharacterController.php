<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CharacterController extends AbstractBaseController
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $chars = $repo->findAll();

        return $this->render(
            'CharacterDatabaseBundle:Character:index.json.twig',
            ['characters' => $chars],
            new JsonResponse()
        );
    }

    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $char = $repo->find($id);

        return $this->render('CharacterDatabaseBundle:Character:show.json.twig', ['char' => $char], new JsonResponse());
    }

    public function storeAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        if (is_null($id)) {
            $character = new Character();
        } else {
            $character = $repo->find($id);
        }
        $jsonBody = json_decode($request->getContent(), true);

        $jsonBody['result'] = $this->get('character_database.character_service')->validateJson($jsonBody);

        return new JsonResponse($jsonBody);
    }
}
