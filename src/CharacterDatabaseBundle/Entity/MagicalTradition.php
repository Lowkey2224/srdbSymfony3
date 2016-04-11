<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalTradition
 *
 * @ORM\Table(name="magical_tradition")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalTraditionRepository")
 */
class MagicalTradition extends AbstractEntity
{
}

