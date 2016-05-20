<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Cyberware;
use CharacterDatabaseBundle\Model\CyberwareModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CyberwareController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $skills = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Cyberware')->findAll();

        return new JsonResponse(CyberwareModel::entityArrayToArray($skills));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function storeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $cyberware = new Cyberware();
        } else {
            $cyberware = $em->getRepository('CharacterDatabaseBundle:Cyberware')->find($id);
            if (is_null($cyberware)) {
                throw new NotFoundHttpException('Cyberware not Found');
            }
        }
        $jsonBody = json_decode($request->getContent(), true);
        $valid = CyberwareModel::isValidArray($jsonBody, false);
        if (!$jsonBody || !$valid) {
            throw new BadRequestHttpException('Json Malformed');
        }


        $cyberware->setName($jsonBody['name']);
        $cyberware->setDescription($jsonBody['type']);
        $cyberwareService = $this->get('character_database.cyberware_service');
        $cyberware->setLevels($cyberwareService->createCyberwareLevels($cyberware, $jsonBody['levels']));
        $em->persist($cyberware);
        $em->flush();

        return new JsonResponse(CyberwareModel::toArray($cyberware));
    }
}
