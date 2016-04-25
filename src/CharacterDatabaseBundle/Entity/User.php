<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Correlation to a user, who should be a partner.
     *
     * @var User
     * @ORM\OneToMany(targetEntity="CharacterDatabaseBundle\Entity\Character", mappedBy="user", fetch="EAGER")
     */
    protected $characters;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDeleted;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param User $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }
}
