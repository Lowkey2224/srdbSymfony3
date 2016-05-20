<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipItem.
 *
 * @ORM\Table(name="equip_item")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\EquipItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EquipItem extends NamedEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="CharacterDatabaseBundle\Entity\Character", inversedBy="items")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }
}
