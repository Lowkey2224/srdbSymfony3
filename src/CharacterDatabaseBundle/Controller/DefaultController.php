<?php

namespace CharacterDatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CharacterDatabaseBundle:Default:index.html.twig');
    }
}
