<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute.
 *
 * @ORM\Table(name="attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\AttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Attribute extends NamedEntity
{

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToAttribute", mappedBy="attribute")
     * @var CharacterToAttribute[]
     */
    protected $characterLink;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\Skill", mappedBy="attribute")
     * @var Skill[] $skills
     */
    protected $skills;

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
     * @param mixed $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }
}
