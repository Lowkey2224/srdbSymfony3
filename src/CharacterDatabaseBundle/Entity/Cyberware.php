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
class Cyberware extends NamedEntity
{

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
}
