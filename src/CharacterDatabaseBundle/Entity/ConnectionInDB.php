<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConnectionInDB.
 *
 * @ORM\Table(name="connection_in_d_b")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\ConnectionInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionInDB extends AbstractEntity
{
    /**
     * Character @var.
     *
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="connectionsInDBTarget")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     */
    protected $target;

    /**
     * Character @var.
     *
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="connectionsInDB")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $character;
    /**
     * integer @var.
     *
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * Gibt den Namen der Connection zurück!
     *
     * @return string
     */
    public function getName()
    {
        return $this->target->getName();
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $owner
     */
    public function setCharacter($owner)
    {
        $this->character = $owner;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }
}
