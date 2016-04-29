<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Totem;
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
        $totems = array_map(function (Totem $totem) {
            return [
                'id' => $totem->getId(),
                'name' => $totem->getName(),
            ];
        }, $totems);

        return new JsonResponse($totems);
    }
}
