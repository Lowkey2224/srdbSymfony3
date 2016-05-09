<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service\CharacterService;

use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\CharacterToAttribute;
use CharacterDatabaseBundle\Entity\CharacterToSkill;
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
        if (!isset($json['karma'])) {
            return false;
        }
        if (!isset($json['reputation'])) {
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
            return;
        }

        $character->setName($jsonBody['name']);
        $character->setRace($jsonBody['race']);
        $character->setOccupation($jsonBody['occupation']);
        $character->setDescription($jsonBody['description']);
        $character->setGoodKarma($jsonBody['karma']);
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
     * @param Character     $character
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
        $attributes = $this->createAttributes($json, $character, $manager);
        $character->setAttributes($attributes);

        return $character;
    }

    /**
     * @param $json
     * @param Character     $character
     * @param ObjectManager $manager
     *
     * @return CharacterToAttribute[]
     */
    private function createAttributes($json, Character $character, ObjectManager $manager)
    {
        $attributeRepository = $manager->getRepository('CharacterDatabaseBundle:Attribute');
        $charAttributeRepository = $manager->getRepository('CharacterDatabaseBundle:CharacterToAttribute');

        $atts = [];
        if (!isset($json['skill'])) {
            return [];
        }
        foreach ($json['attribute'] as $name => $level) {
            $attribute = $attributeRepository->findOneBy(['name' => $name]);
            $characterToAttribute = $charAttributeRepository->findOneBy([
                'attribute' => $attribute,
                'character' => $character,
            ]);
            $characterToAttribute = (is_null($characterToAttribute)) ?
                new CharacterToAttribute() : $characterToAttribute;
            $characterToAttribute->setLevel($level);
            $characterToAttribute->setCharacter($character);
            $characterToAttribute->setAttribute($attribute);
            $atts[] = $characterToAttribute;
        }

        return $atts;
    }
}
