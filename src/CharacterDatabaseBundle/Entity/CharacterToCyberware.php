<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterToCyberware
 *
 * @ORM\Table(name="character_to_cyberware")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToCyberwareRepository")
 */
class CharacterToCyberware extends AbstractEntity
{

    /**
     * @var int
     *
     * @ORM\Column(name="quality", type="integer")
     */
    private $quality;

    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="cyberware")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     * @var Character
     */
    protected $character;

    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\CyberwareLevel", inversedBy="characterLink")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     * @var CyberwareLevel
     */
    protected $cyberware;

    /**
     * Set quality
     *
     * @param integer $quality
     *
     * @return CharacterToCyberware
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    public function getQualityFactor()
    {
        return 1 - (0.2 * ($this->quality - 1));
    }

    public function getQualityName()
    {
        switch ($this->quality) {
            case 4:
                return "Deltaware";
            case 3:
                return "Betwaware";
            case 2:
                return "Alphaware";
            case 1:
            default:
                return "Standardware";
        }
    }

    public function getQualityCode()
    {
        switch ($this->quality) {
            case 4:
                return "delta";
            case 3:
                return "beta";
            case 2:
                return "alpha";
            case 1:
            default:
                return "";
        }
    }

    /**
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param Character $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return CyberwareLevel
     */
    public function getCyberware()
    {
        return $this->cyberware;
    }

    /**
     * @param CyberwareLevel $cyberware
     */
    public function setCyberware($cyberware)
    {
        $this->cyberware = $cyberware;
    }
}
