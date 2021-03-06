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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function mineAction()
    {
        return $this->showForUserAction($this->getUser()->getId());

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showForUserAction($userId)
    {
        $characterRepo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Character');
        $userRepo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User');
        $user = $userRepo->find($userId);
        $chars = $characterRepo->findBy(["user" => $user]);

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
        if (is_null($char)) {
            throw new NotFoundHttpException('Character not found');
        }

        return $this->render(
            'CharacterDatabaseBundle:Character:show.json.twig',
            ['char' => $char],
            new JsonResponse()
        );
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
            if (is_null($character)) {
                throw new NotFoundHttpException('Character not Found');
            }
        }
        $em = $this->getDoctrine()->getManager();
        $jsonBody = json_decode($request->getContent(), true);
        $characterService = $this->get('character_database.character_service');
        if (!$characterService->validateJson($jsonBody)) {
            throw new BadRequestHttpException('Malformed JSON');
        }
        $character->setUser($this->getUser());
        $character = $characterService->updateCharacter($character, $jsonBody, $em);
        $em->persist($character);
        $em->flush();

        return $this->render(
            'CharacterDatabaseBundle:Character:show.json.twig',
            ['char' => $repo->find($character->getId())],
            new JsonResponse()
        );
    }
}
