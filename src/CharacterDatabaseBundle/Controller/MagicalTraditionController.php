<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\MagicalTradition;
use CharacterDatabaseBundle\Model\MagicalTraditionModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MagicalTraditionController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $magicalTraditions = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:MagicalTradition')->findAll();

        return new JsonResponse(MagicalTraditionModel::entityArrayToArray($magicalTraditions));
    }
}
