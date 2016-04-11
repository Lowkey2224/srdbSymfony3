<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specalization
 *
 * @ORM\Table(name="specalization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\SpecalizationRepository")
 */
class Specalization
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

