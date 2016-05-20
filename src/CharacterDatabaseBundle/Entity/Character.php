<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person.
 *
 * @ORM\Table(name="characters")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\PersonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Character extends NamedEntity
{
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
     * @var int
     *          1 = SC, 2 = NSC
     * @ORM\Column(type="integer", nullable=false)
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
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToAttribute",
     *     mappedBy="character", fetch="EAGER", cascade={"persist"})
     */
    protected $attributes;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToSkill",
     *     mappedBy="character", fetch="EAGER", cascade={"persist"})
     **/
    protected $skills;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\CharacterToCyberware",
     *     mappedBy="character", fetch="EAGER", cascade={"persist"})
     **/
    protected $cyberware;

    /**
     * Correlation to a user, who should be a partner.
     *
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
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionNotInDB",
     *      mappedBy="character", fetch="EAGER")
     */
    protected $connectionsNotInDB;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionInDB",
     *     mappedBy="character", fetch="EAGER")
     */
    protected $connectionsInDB;

    /**
     * @var Collection This is the Collection of Characters, which have this Character as Connection.
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\ConnectionInDB", mappedBy="target", fetch="LAZY")
     */
    protected $connectionsInDBTarget;


    /**
     * Calculates the Essence with the current Cyberware
     * @return int
     */
    public function getEssence()
    {
        $essence = 600;
        /** @var CharacterToCyberware $item */
        foreach ($this->cyberware as $item) {
            $essence -= $item->getQualityFactor() * $item->getCyberware()->getCost();
        }
        return $essence/100;
    }

    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->connectionsNotInDB = new ArrayCollection();
        $this->connectionsInDB = new ArrayCollection();
        $this->connectionsInDBTarget = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->cyberware = new ArrayCollection();
        $this->reputation = 0;
        $this->goodKarma = 0;
        $this->karmapool = 0;
    }

    /**
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param string $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
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
     * @return int
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * @param int $reputation
     */
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;
    }

    /**
     * @return int
     */
    public function getGoodKarma()
    {
        return $this->goodKarma;
    }

    /**
     * @param int $goodKarma
     */
    public function setGoodKarma($goodKarma)
    {
        $this->goodKarma = $goodKarma;
    }

    /**
     * @return int
     */
    public function getKarmapool()
    {
        return $this->karmapool;
    }

    /**
     * @param int $karmapool
     */
    public function setKarmapool($karmapool)
    {
        $this->karmapool = $karmapool;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return MagicalCapability
     */
    public function getMagicalCapability()
    {
        return $this->magicalCapability;
    }

    /**
     * @param MagicalCapability $magicalCapability
     */
    public function setMagicalCapability($magicalCapability)
    {
        $this->magicalCapability = $magicalCapability;
    }

    /**
     * @return MagicalTradition
     */
    public function getMagicalTradition()
    {
        return $this->magicalTradition;
    }

    /**
     * @param MagicalTradition $magicalTradition
     */
    public function setMagicalTradition($magicalTradition)
    {
        $this->magicalTradition = $magicalTradition;
    }

    /**
     * @return Totem
     */
    public function getTotem()
    {
        return $this->totem;
    }

    /**
     * @param Totem $totem
     */
    public function setTotem($totem)
    {
        $this->totem = $totem;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes->clear();
        foreach ($attributes as $att) {
            $this->attributes->add($att);
        }
    }

    /**
     * @return Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param Collection $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return Collection
     */
    public function getConnectionsNotInDB()
    {
        return $this->connectionsNotInDB;
    }

    /**
     * @param Collection $connectionsNotInDB
     */
    public function setConnectionsNotInDB($connectionsNotInDB)
    {
        $this->connectionsNotInDB = $connectionsNotInDB;
    }

    /**
     * @return Collection
     */
    public function getConnectionsInDB()
    {
        return $this->connectionsInDB;
    }

    /**
     * @param Collection $connectionsInDB
     */
    public function setConnectionsInDB($connectionsInDB)
    {
        $this->connectionsInDB = $connectionsInDB;
    }

    /**
     * @return Collection
     */
    public function getConnectionsInDBTarget()
    {
        return $this->connectionsInDBTarget;
    }

    /**
     * @param Collection $connectionsInDBTarget
     */
    public function setConnectionsInDBTarget($connectionsInDBTarget)
    {
        $this->connectionsInDBTarget = $connectionsInDBTarget;
    }

    /**
     * @return Collection
     */
    public function getCyberware()
    {
        return $this->cyberware;
    }

    /**
     * @param Collection $cyberware
     */
    public function setCyberware($cyberware)
    {
        $this->cyberware = $cyberware;
    }
}
