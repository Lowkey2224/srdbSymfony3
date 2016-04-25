<?php

namespace CharacterDatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Totem.
 *
 * @ORM\Table(name="totem")
 * @ORM\Entity(repositoryClass="CharacterDatabaseBundle\Repository\TotemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Totem extends AbstractEntity
{
    /**
     * @var MagicalTradition
     * @ORM\ManyToOne(targetEntity="MagicalTradition", inversedBy="totems")
     * @ORM\JoinColumn(name="tradition_id", referencedColumnName="id")
     */
    protected $tradition;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $ruleText;

    /**
     * @return MagicalTradition
     */
    public function getTradition()
    {
        return $this->tradition;
    }

    /**
     * @param MagicalTradition $tradition
     */
    public function setTradition($tradition)
    {
        $this->tradition = $tradition;
    }

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

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRuleText()
    {
        return $this->ruleText;
    }

    /**
     * @param string $ruleText
     */
    public function setRuleText($ruleText)
    {
        $this->ruleText = $ruleText;
    }
}
