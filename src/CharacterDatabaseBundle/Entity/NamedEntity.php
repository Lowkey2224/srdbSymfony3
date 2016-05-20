<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class NamedEntity extends AbstractEntity
{

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string $name Name of the Cyberware
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}