<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalTradition
 *
 * @ORM\Table(name="magical_tradition")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalTraditionRepository")
 * * @ORM\HasLifecycleCallbacks()
 */
class MagicalTradition extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

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
}