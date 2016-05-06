<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Totem;
use CharacterDatabaseBundle\Model\TotemModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TotemController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $totems = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Totem')->findAll();

        return new JsonResponse(TotemModel::entityArrayToArray($totems));
    }
}
