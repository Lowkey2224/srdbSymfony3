<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Skill;
use CharacterDatabaseBundle\Model\SkillModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SkillController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $skills = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Skill')->findAll();

        return new JsonResponse(SkillModel::entityArrayToArray($skills));
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
            $skill = new Skill();
        } else {
            $skill = $em->getRepository('CharacterDatabaseBundle:Skill')->find($id);
            if(is_null($skill)){
                throw new NotFoundHttpException('Skill not Found');
            }
        }
        $jsonBody = json_decode($request->getContent(), true);
        $valid = SkillModel::isValidArray($jsonBody, false);
        if (!$jsonBody || !$valid) {
            throw new BadRequestHttpException('Json Malformed');
        }
        $attribute = $em->getRepository('CharacterDatabaseBundle:Attribute')->find($jsonBody['attribute']['id']);
        if (!$attribute) {
            throw new BadRequestHttpException('Attribute has to be set.');
        }

        $skill->setAttribute($attribute);
        $skill->setName($jsonBody['name']);
        $skill->setType($jsonBody['type']);
        $em->persist($skill);
        $em->flush();

        return new JsonResponse(SkillModel::toArray($skill));
    }
}
