<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CharacterToSkill.
 *
 * @ORM\Table(name="character_to_skill")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToSkillRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"character","skill"}, message="Dieser Character hat diese Fähigkeit bereits")
 */
class CharacterToSkill extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="skills")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Skill", inversedBy="characterLink")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $skill;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterSkillToSpecialization", mappedBy="charSkill", fetch="EAGER")
     */
    protected $specializations;

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return Character
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

    /**
     * @param mixed $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
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
