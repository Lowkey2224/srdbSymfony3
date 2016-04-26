<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;

use CharacterDatabaseBundle\Entity\User;
use CharacterDatabaseBundle\Model\UserModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
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
     */
    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User');
        $user = $repo->find($id);
        $model = new UserModel($user);

        return new JsonResponse($model->toArray());
    }

    public function indexAction()
    {
        $user = $this->getDoctrine()->getRepository('CharacterDatabaseBundle:User')->findAll();
        $data = array_map(function (User $user) {
            $model = new UserModel($user);

            return $model->toArray();
        }, $user);

        return new JsonResponse($data);
    }
}
