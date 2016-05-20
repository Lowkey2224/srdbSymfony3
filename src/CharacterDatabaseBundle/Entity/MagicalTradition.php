<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalTradition.
 *
 * @ORM\Table(name="magical_tradition")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalTraditionRepository")
 * * @ORM\HasLifecycleCallbacks()
 */
class MagicalTradition extends NamedEntity
{
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var Totem
     * @ORM\OneToMany(targetEntity="Totem", mappedBy="tradition")
     */
    protected $totems;

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
     * @return Totem
     */
    public function getTotems()
    {
        return $this->totems;
    }

    /**
     * @param Totem $totems
     */
    public function setTotems($totems)
    {
        $this->totems = $totems;
    }
}
