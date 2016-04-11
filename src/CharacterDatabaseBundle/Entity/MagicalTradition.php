<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalTradition
 *
 * @ORM\Table(name="magical_tradition")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalTraditionRepository")
 */
class MagicalTradition
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

