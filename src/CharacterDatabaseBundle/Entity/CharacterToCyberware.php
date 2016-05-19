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
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

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
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Cyberware", inversedBy="chharacters")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     * @var Cyberware
     */
    protected $cyberware;




    /**
     * Set level
     *
     * @param integer $level
     *
     * @return CharacterToCyberware
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

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
}

