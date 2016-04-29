<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SkillController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $skills = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Skill')->findAll();
        $skills = array_map(function (Skill $skill) {
            return [
                'id' => $skill->getId(),
                'name' => $skill->getName(),
            ];
        }, $skills);

        return new JsonResponse($skills);
    }
}
