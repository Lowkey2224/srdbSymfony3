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
class Skill extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, unique=true)
     */
    protected $name;

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



    public function getTypeName(){
        switch ($this->type){
            case 1:
                return "Aktionsfähigkeit";
            case 2:
                return "Wissensfähigkeit";
            case 3:
                return "Sprache";
        }
        return "unbekannt";
    }

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
