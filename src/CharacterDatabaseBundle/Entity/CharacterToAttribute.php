<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterToAttribute
 *
 * @ORM\Table(name="character_to_attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToAttributeRepository")
 */
class CharacterToAttribute
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

