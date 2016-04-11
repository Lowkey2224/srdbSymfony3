<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterToSkill
 *
 * @ORM\Table(name="character_to_skill")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToSkillRepository")
 */
class CharacterToSkill
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

