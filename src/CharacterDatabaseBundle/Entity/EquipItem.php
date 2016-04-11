<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipItem
 *
 * @ORM\Table(name="equip_item")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\EquipItemRepository")
 */
class EquipItem extends AbstractEntity
{
}

