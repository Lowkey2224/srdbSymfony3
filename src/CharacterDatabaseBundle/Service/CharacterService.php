<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service;

use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\MagicalCapability;
use Doctrine\Common\Persistence\ObjectManager;

class CharacterService
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
        if (!isset($json['name'])) {
            return false;
        }
        if (!isset($json['race'])) {
            return false;
        }
        if (!isset($json['occupation'])) {
            return false;
        }
        if (!isset($json['description'])) {
            return false;
        }
        if (!isset($json['goodKarma'])) {
            return false;
        }
        if (!isset($json['reputaion'])) {
            return false;
        }
        if (!isset($json['type'])) {
            return false;
        }
        if (isset($json['magical']) && isset($json['tradition']) && $json['tradition'] == '') {
            if (!isset($json['totem'])) {
                return false;
            }
        }

        return true;
    }

    public function updateCharacter(Character $character, $jsonBody, ObjectManager $manager)
    {
        if (!$this->validateJson($jsonBody)) {
            return null;
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
        if(isset($jsonBody['tradition'])){
            $tradition = $manager->getRepository('CharacterDatabaseBundle:MagicalTradition')
                ->findOneBy(['name' => $jsonBody['tradition']]);
            $character->setMagicalTradition($tradition);
        }
        if(isset($jsonBody['totem'])){
            $totem = $manager->getRepository('CharacterDatabaseBundle:Totem')
                ->findOneBy(['name' => $jsonBody['totem']]);
            $character->setTotem($totem);
        }
        return $character;

    }
}
