<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipItem
 *
 * @ORM\Table(name="equip_item")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\EquipItemRepository")
 */
class EquipItem
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

