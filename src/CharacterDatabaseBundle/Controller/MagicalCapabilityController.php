<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\MagicalCapability;
use CharacterDatabaseBundle\Model\MagicalCapabilityModel;
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
        $magicalCapabilities = $this->getDoctrine()
            ->getRepository('CharacterDatabaseBundle:MagicalCapability')
            ->findAll();

        return new JsonResponse(MagicalCapabilityModel::entityArrayToArray($magicalCapabilities));
    }
}
