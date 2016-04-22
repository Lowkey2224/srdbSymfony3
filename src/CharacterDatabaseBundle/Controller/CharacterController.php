<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Controller;


use CharacterDatabaseBundle\Entity\Character;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends Controller
{

    public function indexAction()
    {
        $json = '[{"id":1,"name":"Lodur","user":{"name":"Loki","id":1},"skills":[{"name":"Athletik","level":3},{"name":"Gebräuche","level":3}],"description":"Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.","occupation":"Occupation","goodKarma":110,"reputaion":250,"type":"Spieler Character","images":["images/gem-02.gif","images/gem-05.gif","images/gem-09.gif"],"posts":[]},{"id":1,"name":"Nigel","user":{"name":"Loki","id":1},"skills":[{"name":"Athletik","level":3},{"name":"Gebräuche","level":3}],"description":"Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.","occupation":"Occupation","goodKarma":110,"reputaion":250,"type":"Spieler Character","images":["images/gem-02.gif","images/gem-05.gif","images/gem-09.gif"],"posts":[]}]';

//        $c = new Character();
        return new JsonResponse(json_decode($json));

//        return $this->render('CharacterDatabaseBundle:Default:index.html.twig');
    }
}