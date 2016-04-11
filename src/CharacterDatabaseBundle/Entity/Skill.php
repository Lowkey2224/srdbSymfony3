<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\SkillRepository")
 */
class Skill extends AbstractEntity
{
}

