<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterToAttribute
 *
 * @ORM\Table(name="character_to_attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToAttributeRepository")
 */
class CharacterToAttribute  extends AbstractEntity
{
}

