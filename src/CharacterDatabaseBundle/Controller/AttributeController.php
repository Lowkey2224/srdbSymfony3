<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\Attribute;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AttributeController extends AbstractBaseController
{
    /**
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $atts = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:Attribute')->findAll();
        $atts = array_map(function (Attribute $att) {
            return [
                'id' => $att->getId(),
                'name' => $att->getName(),
            ];
        }, $atts);

        return new JsonResponse($atts);
    }
}
