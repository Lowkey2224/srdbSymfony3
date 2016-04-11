<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterSkillToSpecialization
 *
 * @ORM\Table(name="character_skill_to_specialization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterSkillToSpecializationRepository")
 */
class CharacterSkillToSpecialization
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

