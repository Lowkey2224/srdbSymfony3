<?php

namespace CharacterDatabaseBundle\Controller;

class DefaultController extends AbstractBaseController
{
    public function indexAction()
    {
        return $this->render('CharacterDatabaseBundle:Default:index.html.twig');
    }
}
