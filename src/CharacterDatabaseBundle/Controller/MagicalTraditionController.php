<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\MagicalTradition;
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
        $magicalTraditions = array_map(function (MagicalTradition $magicalTradition) {
            return [
                'id' => $magicalTradition->getId(),
                'name' => $magicalTradition->getName(),
            ];
        }, $magicalTraditions);

        return new JsonResponse($magicalTraditions);
    }
}
