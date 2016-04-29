<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\MagicalCapability;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MagicalCapabilityController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $magicalCapabilities = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:MagicalCapability')->findAll();
        $magicalCapabilities = array_map(function (MagicalCapability $magicalCapability) {
            return [
                'id' => $magicalCapability->getId(),
                'name' => $magicalCapability->getName(),
            ];
        }, $magicalCapabilities);

        return new JsonResponse($magicalCapabilities);
    }
}
