<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Character;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CharacterController extends AbstractBaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
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

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $char = $repo->find($id);

        return $this->render('CharacterDatabaseBundle:Character:show.json.twig', ['char' => $char], new JsonResponse());
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function storeAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        if (is_null($id)) {
            $character = new Character();
        } else {
            $character = $repo->find($id);
        }
        $em = $this->getDoctrine()->getManager();
        $jsonBody = json_decode($request->getContent(), true);
        $characterService = $this->get('character_database.character_service');
        $jsonBody['result'] = $characterService->validateJson($jsonBody);
        if(!$jsonBody['result']){
            throw new BadRequestHttpException("Malformed JSON");
        }
        $character->setUser($this->getUser());
        $character = $characterService->updateCharacter($character, $jsonBody, $em);
        $em->persist($character);
        $em->flush();
        return $this->render('CharacterDatabaseBundle:Character:show.json.twig', ['char' => $character], new JsonResponse());
    }
}
