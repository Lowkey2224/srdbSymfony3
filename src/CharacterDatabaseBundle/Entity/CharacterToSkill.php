<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterToSkill
 *
 * @ORM\Table(name="character_to_skill")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterToSkillRepository")
 */
class CharacterToSkill extends AbstractEntity
{
}

