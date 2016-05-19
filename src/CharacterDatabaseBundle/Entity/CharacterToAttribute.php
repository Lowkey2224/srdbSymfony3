<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CharacterToAttribute.
 *
 * @ORM\Table(name="character_to_attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToAttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"character","attribute"}, message="Dieser Character hat dieses Attribut bereits")
 */
class CharacterToAttribute extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="attributes")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @var Character
     */
    protected $character;

    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Attribute", inversedBy="characterLink")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     * @var Attribute
     */
    protected $attribute;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }
}
