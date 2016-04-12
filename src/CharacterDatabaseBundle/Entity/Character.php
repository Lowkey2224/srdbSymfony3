<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="characters")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\PersonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Character extends AbstractEntity
{



    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $race;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $occupation;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $reputation;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodKarma;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $karmapool;

    /**
     * @var integer
     * 1 = SC, 2 = NSC
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @var MagicalCapability
     * @ORM\ManyToOne(targetEntity="MagicalCapability")
     * @ORM\JoinColumn(name="magical_capability_id", referencedColumnName="id")
     */
    protected $magicalCapability;

    /**
     * @var MagicalTradition
     * @ORM\ManyToOne(targetEntity="MagicalTradition")
     * @ORM\JoinColumn(name="tradition_id", referencedColumnName="id")
     */
    protected $magicalTradition;

    /**
     * @var Totem
     * @ORM\ManyToOne(targetEntity="Totem")
     * @ORM\JoinColumn(name="totem_id", referencedColumnName="id")
     */
    protected $totem;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToAttribute", mappedBy="character", fetch="EAGER")
     */
    protected $attributes;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToSkill", mappedBy="character", fetch="EAGER")
     **/
    protected $skills;

    /**
     * Correlation to a user, who should be a partner.
     * @var User
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\EquipItem", mappedBy="character", fetch="EAGER")
     */
    protected $items;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionNotInDB", mappedBy="character", fetch="EAGER")
     */
    protected $connectionsNotInDB;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionInDB", mappedBy="character", fetch="EAGER")
     */
    protected $connectionsInDB;

    /**
     * @var Collection This is the Collection of Characters, which have this Character as Connection.
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionInDB", mappedBy="target", fetch="LAZY")
     */
    protected $connectionsInDBTarget;



    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->connectionsNotInDB = new ArrayCollection();
        $this->connectionsInDB = new ArrayCollection();
        $this->connectionsInDBTarget = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->reputation = 0;
        $this->goodKarma = 0;
        $this->karmapool = 0;
    }
}

