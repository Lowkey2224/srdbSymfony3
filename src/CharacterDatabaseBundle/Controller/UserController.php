<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\User;
use CharacterDatabaseBundle\Model\UserModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends AbstractBaseController
{
    /**
     * @ApiDoc(
     *      description="Zeigt Details für einen User",
     *     method="Get",
     *     input="CharacterDatabaseBundle\Entity\User",
     *  output="CharacterDatabaseBundle\Model\UserModel"
     *     )
     * Action route <i>user_show</i> with URL: <i>
     *
     * @param $id
     *
     * @return JsonResponse
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User');
        $user = $repo->find($id);
        if (is_null($user)) {
            throw new NotFoundHttpException('User not found');
        }
        $model = new UserModel($user);

        return new JsonResponse($model->toArray());
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction()
    {
        $user = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User')->findAll();
        $data = array_map(function (User $user) {
            $model = new UserModel($user);

            return $model->toArray();
        }, $user);

        return new JsonResponse($data);
    }

    public function isLoggedInAction()
    {
        return new JsonResponse($this->isLoggedIn());
    }
}
