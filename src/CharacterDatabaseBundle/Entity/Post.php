<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\PostRepository")
 */
class Post extends AbstractEntity
{
}

