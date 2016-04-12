<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute
 *
 * @ORM\Table(name="attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\AttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Attribute extends AbstractEntity
{

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=45)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToAttribute", mappedBy="attribute")
     */
    protected $characterLink;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\Skill", mappedBy="attribute")
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
