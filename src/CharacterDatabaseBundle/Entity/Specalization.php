<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specalization
 *
 * @ORM\Table(name="specalization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\SpecalizationRepository")
 */
class Specalization extends AbstractEntity
{
}

