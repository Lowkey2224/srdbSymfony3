<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Specalization.
 *
 * @ORM\Table(name="specalization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\SpecalizationRepository")
 * @UniqueEntity(fields={"skill","name"}, message="Diese Spezialisierung existiert bereits.")
 * @ORM\HasLifecycleCallbacks()
 */
class Specialization extends NamedEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Skill", inversedBy="specializations")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    protected $skill;


    /**
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterSkillToSpecialization",
     * mappedBy="specialization")
     */
    protected $specializations;



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
