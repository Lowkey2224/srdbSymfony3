<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ConnectionNotInDB
 *
 * @ORM\Table(name="connection_not_in_d_b")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\ConnectionNotInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionNotInDB extends AbstractEntity
{
    /**
     * @var String der Connection
     * @ORM\Column(type="string")
     */
    protected $target;

    /**
     * Character @var
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="connectionsNotInDB")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $character;
    /**
     * integer @var
     * @ORM\Column(type="integer")
     */
    protected $level;


    /**
     * @return String
     */
    public function getName()
    {
        return $this->target;
    }

    /**
     * @param integer $level
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
     * @param mixed $name
     */
    public function setTarget($name)
    {
        $this->target = $name;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }



}
