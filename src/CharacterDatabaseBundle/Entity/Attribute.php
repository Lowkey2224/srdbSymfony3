<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attribute
 *
 * @ORM\Table(name="attribute")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\AttributeRepository")
 */
class Attribute extends AbstractEntity
{

}
