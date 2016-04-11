<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharacterSkillToSpecialization
 *
 * @ORM\Table(name="character_skill_to_specialization")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\CharacterSkillToSpecializationRepository")
 */
class CharacterSkillToSpecialization extends AbstractEntity
{
}

