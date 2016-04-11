<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Totem
 *
 * @ORM\Table(name="totem")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\TotemRepository")
 */
class Totem extends AbstractEntity
{
}

