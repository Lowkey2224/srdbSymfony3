<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConnectionNotInDB
 *
 * @ORM\Table(name="connection_not_in_d_b")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\ConnectionNotInDBRepository")
 */
class ConnectionNotInDB
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

