<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Totem
 *
 * @ORM\Table(name="totem")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\TotemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Totem extends AbstractEntity
{
    /**
     * @var MagicalTradition
     * @ORM\ManyToOne(targetEntity="MagicalTradition", inversedBy="totems")
     * @ORM\JoinColumn(name="tradition_id", referencedColumnName="id")
     */
    protected $tradition;

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
     * @var string
     * @ORM\Column(type="text")
     */
    protected $ruleText;

}