<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CharacterSkillToSpecialization.
 *
 * @ORM\Table(name="character_skill_to_specialization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterSkillToSpecializationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"specialization","charSkill"}, message="Dieser Character hat diese Spezialisierung bereits")
 */
class CharacterSkillToSpecialization extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\CharacterToSkill", inversedBy="specializations")
     * @ORM\JoinColumn(name="charskill_id", referencedColumnName="id")
     */
    protected $charSkill;

    /**
     * @var Specialization
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Specialization", inversedBy="specializations")
     * @ORM\JoinColumn(name="specialization_id", referencedColumnName="id")
     */
    protected $specialization;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    public function getName()
    {
        return $this->specialization->getName();
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
    public function setCharSkill($skill)
    {
        $this->charSkill = $skill;
    }

    /**
     * @return CharacterToSkill
     */
    public function getCharSkill()
    {
        return $this->charSkill;
    }

    /**
     * @param Specialization $spec
     */
    public function setSpecialization($spec)
    {
        $this->specialization = $spec;
    }

    /**
     * @return Specialization
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }
}
