<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Models;


use CharacterDatabaseBundle\Entity\Cyberware;
use CharacterDatabaseBundle\Entity\CyberwareLevel;
use CharacterDatabaseBundle\Model\CyberwareModel;
use Doctrine\Common\Collections\ArrayCollection;

class CyberwareModelTest extends AbstractModelTest
{

    /**
     * Returns an array with the name of all valid Fields
     * @return array
     */
    protected function getValidFields()
    {
        return ['id', 'name', 'description', 'levels'];
    }

    /**
     * The Method used to check if the array is valid
     * @param $array
     * @param bool $withId
     * @return bool
     */
    protected function validationMethod($array, $withId = true)
    {
        return CyberwareModel::isValidArray($array, $withId);
    }

    /**
     * Returns an Array of Entities, that will be rendered into an Array
     * @return array
     */
    protected function getEntities()
    {
        $entities = [];
        for ($i = 0; $i < 4; $i++) {
            $entity = new Cyberware();
            $entity->setName('Cyberware'.$i);
            $entity->setId($i);
            $entity->setDescription('Description'.$i);
            $levels = new ArrayCollection();
            for ($j = 1; $j < 10; $j++) {
                $level = new CyberwareLevel();
                $level->setId($j);
                $level->setCyberware($entity);
                $level->setCost($j*10);
                $level->setEffect("Guter Effekt".$j);
                $levels->add($level);
            }
            $entity->setLevels($levels);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * Renders the given Entity into an Array
     * @param $entity
     * @return array
     */
    protected function toArrayMethod($entity)
    {
        return CyberwareModel::toArray($entity);
    }

    /**
     * @param $fieldName
     * @param $arrayField
     * @param Cyberware $entity
     */
    protected function assertEqualAttribute($fieldName, $arrayField, $entity)
    {
        if($fieldName == "levels"){
            for($i = 0; $i < count($arrayField); $i++) {
                $this->assertEquals($entity->getLevels()->get($i)->getId(), $arrayField[$i]['id']);
                $this->assertEquals($entity->getLevels()->get($i)->getCost(), $arrayField[$i]['cost']);
                $this->assertEquals($entity->getLevels()->get($i)->getLevel(), $arrayField[$i]['level']);
                $this->assertEquals($entity->getLevels()->get($i)->getEffect(), $arrayField[$i]['effect']);
            }
        }else{
            parent::assertEqualAttribute($fieldName, $arrayField, $entity);
        }

    }
}