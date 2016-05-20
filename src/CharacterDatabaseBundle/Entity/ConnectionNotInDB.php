<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConnectionNotInDB.
 *
 * @ORM\Table(name="connection_not_in_d_b")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\ConnectionNotInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionNotInDB extends NamedEntity
{

    /**
     * Character @var.
     *
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="connectionsNotInDB")
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
     * @param int $level
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
}
