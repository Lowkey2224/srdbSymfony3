<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cyberware An Item of Cyberware.
 * @ORM\Table(name="cyberware")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CyberwareRepository")
 * @ORM\HasLifecycleCallbacks()
 * @package CharacterDatabaseBundle\Entity
 */
class Cyberware extends AbstractEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string $name Name of the Cyberware
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string $description The Textual description of the Cyberware. NOT RULETEXT
     */
    protected $description;

    /**
     * @ORM\OneToMAny(targetEntity="CharacterDatabaseBundle\Entity\CyberwareLevel", mappedBy="cyberware")
     * @var CyberwareLevel[] $levels
     */
    protected $levels;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * @param CyberwareLevel[] $levels
     */
    public function setLevels($levels)
    {
        $this->levels = $levels;
    }

    /**
     * @return CharacterToCyberware
     */
    public function getCharacterLink()
    {
        return $this->characterLink;
    }

    /**
     * @param CharacterToCyberware $characterLink
     */
    public function setCharacterLink($characterLink)
    {
        $this->characterLink = $characterLink;
    }





}