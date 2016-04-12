<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends AbstractEntity
{

    /**
     * Correlation to a user, who should be a partner.
     * @var User
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\Character", mappedBy="user", fetch="EAGER")
     */
    protected $characters;

}

