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

    public function storeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $skill = $em->getRepository('CharacterDatabaseBundle:Skill')->find($id);
        } else {
            $skill = new Skill();
        }
        $jsonBody = json_decode($request->getContent(), true);
        if (!$jsonBody) {
            throw new BadRequestHttpException('Json Malformed');
        }
        $attribute = $em->getRepository('CharacterDatabaseBundle:Attribute')->find($jsonBody['attribute']['id']);
        if (!$attribute) {
            throw new BadRequestHttpException('Attribute has to be set.');
        }

        $skill->setAttribute($attribute);
        $skill->setName($jsonBody['name']);
        $skill->setType($jsonBody['type']);

        return new JsonResponse($jsonBody);
    }
}
