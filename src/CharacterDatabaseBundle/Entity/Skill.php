<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill.
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\SkillRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Skill extends NamedEntity
{
    const TYPE_ACTION_SKILL = 1;
    const TYPE_ACTION_SKILL_NAME = 'Aktionsfähigkeit';
    const TYPE_KNOWLEDGE_SKILL = 2;
    const TYPE_KNOWLEDGE_SKILL_NAME = 'Wissensfähigkeit';
    const TYPE_LANGUAGE_SKILL = 3;
    const TYPE_LANGUAGE_SKILL_NAME = 'Sprache';

    /**
     * @var int
     *          1 = Aktionsskill, 2 = Wissenskill, 3 = Sprachen
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Attribute", inversedBy="skills")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $attribute;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToSkill", mappedBy="skill")
     */
    protected $characterLink;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\Specialization", mappedBy="skill")
     */
    protected $specializations;

    public function getTypeName()
    {
        switch ($this->type) {
            case self::TYPE_ACTION_SKILL:
                return self::TYPE_ACTION_SKILL_NAME;
            case self::TYPE_KNOWLEDGE_SKILL:
                return self::TYPE_KNOWLEDGE_SKILL_NAME;
            case self::TYPE_LANGUAGE_SKILL:
                return self::TYPE_LANGUAGE_SKILL_NAME;
        }

        return 'unbekannt';
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $characterLink
     */
    public function setCharacterLink($characterLink)
    {
        $this->characterLink = $characterLink;
    }

    /**
     * @return mixed
     */
    public function getCharacterLink()
    {
        return $this->characterLink;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $specializations
     */
    public function setSpecializations($specializations)
    {
        $this->specializations = $specializations;
    }

    /**
     * @return mixed
     */
    public function getSpecializations()
    {
        return $this->specializations;
    }
}
