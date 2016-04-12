<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagicalCapability
 *
 * @ORM\Table(name="magical_capability")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\MagicalCapabilityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MagicalCapability extends AbstractEntity
{

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
}

