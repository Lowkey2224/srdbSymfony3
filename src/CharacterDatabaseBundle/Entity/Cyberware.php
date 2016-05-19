<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Entity;

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
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToCyberware", mappedBy="cyberware")
     * @var CharacterToCyberware
     */
    protected $characterLink;



}