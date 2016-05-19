<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CyberwareLevel
 *
 * @ORM\Table(name="cyberware_level")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CyberwareLevelRepository")
 */
class CyberwareLevel extends AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="effect", type="string", length=255)
     */
    private $effect;

    /**
     * @var int Cost divided by 100, so it we do not use floating numbers
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var Cyberware $cyberware
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Cyberware", inversedBy="levels")
     * @ORM\JoinColumn(name="cyberware_id", referencedColumnName="id")
     */
    private $cyberware;


    /**
     * Set level
     *
     * @param integer $level
     *
     * @return CyberwareLevel
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
     * Set effect
     *
     * @param string $effect
     *
     * @return CyberwareLevel
     */
    public function setEffect($effect)
    {
        $this->effect = $effect;

        return $this;
    }

    /**
     * Get effect
     *
     * @return string
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return CyberwareLevel
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return Cyberware
     */
    public function getCyberware()
    {
        return $this->cyberware;
    }

    /**
     * @param Cyberware $cyberware
     */
    public function setCyberware($cyberware)
    {
        $this->cyberware = $cyberware;
    }


}

