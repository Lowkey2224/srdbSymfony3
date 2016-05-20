<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Models;


use CharacterDatabaseBundle\Entity\Attribute;
use CharacterDatabaseBundle\Entity\Skill;
use CharacterDatabaseBundle\Model\SkillModel;

class SkillModelTest extends AbstractModelTest
{

    /**
     * Returns an array with the name of all valid Fields
     * @return array
     */
    protected function getValidFields()
    {
        return ['id', 'name', 'type', 'attribute'];
    }

    /**
     * The Method used to check if the array is valid
     * @param $array
     * @param bool $withId
     * @return bool
     */
    protected function validationMethod($array, $withId = true)
    {
        return SkillModel::isValidArray($array, $withId);
    }

    /**
     * Returns an Array of Entities, that will be rendered into an Array
     * @return array
     */
    protected function getEntities()
    {
        $entities = [];
        for ($i = 0; $i < 4; $i++) {
            $entity = new Skill();
            $entity->setName('Skill'.$i);
            $entity->setId($i);
            $entity->setType($i % 3 + 1);
            $attribute = new Attribute();
            $attribute->setId($i);
            $attribute->setName('Attribute'.$i);
            $entity->setAttribute($attribute);
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
        return SkillModel::toArray($entity);
    }

    /**
     * @param $fieldName
     * @param $arrayField
     * @param Skill $entity
     */
    protected function assertEqualAttribute($fieldName, $arrayField, $entity)
    {
        if ($fieldName == "type") {
            $this->assertEquals($entity->getType(), $arrayField['id']);
            $this->assertEquals($entity->getTypeName(), $arrayField['name']);
        } elseif ($fieldName == "attribute") {
            $this->assertEquals($entity->getAttribute()->getId(), $arrayField['id']);
            $this->assertEquals($entity->getAttribute()->getName(), $arrayField['name']);
        } else {
            parent::assertEqualAttribute($fieldName, $arrayField, $entity);
        }
    }
}