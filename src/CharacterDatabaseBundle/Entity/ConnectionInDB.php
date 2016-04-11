<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConnectionInDB
 *
 * @ORM\Table(name="connection_in_d_b")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\ConnectionInDBRepository")
 */
class ConnectionInDB extends AbstractEntity
{
}

