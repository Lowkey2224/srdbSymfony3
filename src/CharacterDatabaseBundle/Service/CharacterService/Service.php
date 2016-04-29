<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service\CharacterService;

use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\MagicalCapability;
use Doctrine\Common\Persistence\ObjectManager;

class Service
{
    /**
     * Checks if the associative array is a valid Character.
     *
     * @param $json
     *
     * @return bool
     */
    public function validateJson($json)
    {
        $return = isset($json['name']);
        $return = ($return) ? isset($json['race']) : false;
        $return = ($return) ? isset($json['occupation']) : false;
        $return = ($return) ? isset($json['description']) : false;
        $return = ($return) ? isset($json['goodKarma']) : false;
        $return = ($return) ? isset($json['reputaion']) : false;
        $return = ($return) ? isset($json['type']) : false;
        $return = ($return) ? isset($json['type']) : false;
        if (isset($json['magical']) && isset($json['tradition']) && $json['tradition'] == '') {
            if (!isset($json['totem'])) {
                return false;
            }
        }

        return $return;
    }

    public function updateCharacter(Character $character, $jsonBody, ObjectManager $manager)
    {
        if (!$this->validateJson($jsonBody)) {
            return;
        }

        $character->setName($jsonBody['name']);
        $character->setRace($jsonBody['race']);
        $character->setOccupation($jsonBody['occupation']);
        $character->setDescription($jsonBody['description']);
        $character->setGoodKarma($jsonBody['goodKarma']);
        $character->setReputation($jsonBody['reputaion']);
        $character->setType($jsonBody['type']);
        if (isset($jsonBody['magical'])) {
            $magicalCapability = $manager->getRepository('CharacterDatabaseBundle:MagicalCapability')
                ->findOneBy(['name' => $jsonBody['magical']]);
            $character->setMagicalCapability($magicalCapability);
        }
        if (isset($jsonBody['tradition'])) {
            $tradition = $manager->getRepository('CharacterDatabaseBundle:MagicalTradition')
                ->findOneBy(['name' => $jsonBody['tradition']]);
            $character->setMagicalTradition($tradition);
        }
        if (isset($jsonBody['totem'])) {
            $totem = $manager->getRepository('CharacterDatabaseBundle:Totem')
                ->findOneBy(['name' => $jsonBody['totem']]);
            $character->setTotem($totem);
        }

        return $character;
    }
}
