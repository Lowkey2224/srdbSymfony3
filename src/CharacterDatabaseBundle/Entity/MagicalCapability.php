<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalCapability
 *
 * @ORM\Table(name="magical_capability")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalCapabilityRepository")
 */
class MagicalCapability
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

