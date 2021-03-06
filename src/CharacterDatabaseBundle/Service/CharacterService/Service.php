<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service\CharacterService;

use CharacterDatabaseBundle\Entity\Attribute;
use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\CharacterToAttribute;
use CharacterDatabaseBundle\Entity\CharacterToSkill;
use CharacterDatabaseBundle\Entity\MagicalCapability;
use CharacterDatabaseBundle\Service\LoggerAwareService;
use Doctrine\Common\Persistence\ObjectManager;

class Service extends LoggerAwareService
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
        $return = $this->validateJsonBasicInfo($json);
        if (!isset($json['goodKarma'])) {
            return false;
        }
        if (!isset($json['reputation'])) {
            return false;
        }
        if (!isset($json['type'])) {
            return false;
        }
        $return = ($return) ? $this->validateJsonMagical($json) : false;

        return $return;
    }

    private function validateJsonBasicInfo($json)
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

        return true;
    }

    private function validateJsonMagical($json)
    {

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
            return;
        }

        $character->setName($jsonBody['name']);
        $character->setRace($jsonBody['race']);
        $character->setOccupation($jsonBody['occupation']);
        $character->setDescription($jsonBody['description']);
        $character->setDescriptionContentType($jsonBody['descriptionContentType']);
        $character->setGoodKarma($jsonBody['goodKarma']);
        $character->setReputation($jsonBody['reputation']);
        $character->setType($jsonBody['type']);
        if (isset($jsonBody['capability'])) {
            $magicalCapability = $manager->getRepository('CharacterDatabaseBundle:MagicalCapability')
                ->find($jsonBody['capability']);
            $character->setMagicalCapability($magicalCapability);
        }
        if (isset($jsonBody['tradition'])) {
            $tradition = $manager->getRepository('CharacterDatabaseBundle:MagicalTradition')
                ->find($jsonBody['tradition']);
            $character->setMagicalTradition($tradition);
        }
        if (isset($jsonBody['totem'])) {
            $totem = $manager->getRepository('CharacterDatabaseBundle:Totem')
                ->find($jsonBody['totem']);
            $character->setTotem($totem);
        }
        $character = $this->addSkills($jsonBody, $character, $manager);
        $character = $this->setAttributes($jsonBody, $character, $manager);

        return $character;
    }

    private function addSkills($json, Character $character, ObjectManager $manager)
    {
        $newSkills = $this->createSkills($json, $character, $manager);
        $oldSkills = $character->getSkills();
        /*
         * Merge Skills together
         * @var  $skills CharacterToSkill[]
         */
        foreach ($newSkills as $charSkill) {
            $oldSkills->filter(function (CharacterToSkill $elem) use ($charSkill) {
                return $elem->getSkill()->getId() == $charSkill->getSkill()->getId();
            });
            $oldSkills->add($charSkill);
        }
        $character->setSkills($oldSkills);

        return $character;
    }

    /**
     * @param $json
     * @param Character $character
     * @param ObjectManager $manager
     *
     * @return CharacterToSkill[]
     */
    private function createSkills($json, Character $character, ObjectManager $manager)
    {
        $skillRepo = $manager->getRepository('CharacterDatabaseBundle:Skill');
        $characterToSkillRepo = $manager->getRepository('CharacterDatabaseBundle:CharacterToSkill');

        $skills = [];
        if (!isset($json['skill'])) {
            return [];
        }
        foreach ($json['skill'] as $name => $level) {
            $skill = $skillRepo->findOneBy(['name' => $name]);
            $characterToSkill = $characterToSkillRepo->findOneBy(['skill' => $skill, 'character' => $character]);
            $characterToSkill = (is_null($characterToSkill)) ? new CharacterToSkill() : $characterToSkill;
            $characterToSkill->setLevel($level);
            $characterToSkill->setCharacter($character);
            $characterToSkill->setSkill($skill);
            $skills[] = $characterToSkill;
        }

        return $skills;
    }

    private function setAttributes($json, Character $character, ObjectManager $manager)
    {

        $attributes = (isset($json['attribute'])) ?
            $this->createAttributes($json, $character, $manager) :
            $this->createEmptyAttributes($character, $manager);
        $character->setAttributes($attributes);

        return $character;
    }

    /**
     * @param $json
     * @param Character $character
     * @param ObjectManager $manager
     *
     * @return CharacterToAttribute[]
     */
    private function createAttributes($json, Character $character, ObjectManager $manager)
    {
        $attributeRepository = $manager->getRepository('CharacterDatabaseBundle:Attribute');
        $charAttributeRepository = $manager->getRepository('CharacterDatabaseBundle:CharacterToAttribute');

        $atts = [];
        foreach ($json['attribute'] as $name => $level) {
            $attribute = $attributeRepository->findOneBy(['name' => $name]);
            $characterToAttribute = $charAttributeRepository->findOneBy([
                'attribute' => $attribute,
                'character' => $character,
            ]);
            $characterToAttribute = (is_null($characterToAttribute)) ?
                new CharacterToAttribute() : $characterToAttribute;
            $atts[] = $this->setAttribute($character, $attribute, $characterToAttribute, $level);
        }

        return $atts;
    }

    private function createEmptyAttributes(Character $character, ObjectManager $manager)
    {
        $initialLevel = 1;
        $attributeRepository = $manager->getRepository('CharacterDatabaseBundle:Attribute');
        $charAttributeRepository = $manager->getRepository('CharacterDatabaseBundle:CharacterToAttribute');
        $attributes = $attributeRepository->findAll();
        $arr = [];
        foreach ($attributes as $attribute) {
            $criteria = ['attribute' => $attribute, 'character' => $character];
            //We dont want to overwrite any Attributes
            if (!$charAttributeRepository->findOneBy($criteria)) {
                $arr[] = $this->setAttribute($character, $attribute, new CharacterToAttribute(), $initialLevel);
            }
        }

        return $arr;
    }

    private function setAttribute(
        Character $character,
        Attribute $attribute,
        CharacterToAttribute $characterToAttribute,
        $level
    ) {

        $characterToAttribute->setLevel($level);
        $characterToAttribute->setCharacter($character);
        $characterToAttribute->setAttribute($attribute);

        return $characterToAttribute;
    }
}
