<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\PersonRepository")
 */
class Person extends AbstractEntity
{
}

