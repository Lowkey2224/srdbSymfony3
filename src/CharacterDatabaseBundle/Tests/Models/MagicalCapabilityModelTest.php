<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Models;


use CharacterDatabaseBundle\Entity\MagicalCapability;
use CharacterDatabaseBundle\Model\MagicalCapabilityModel;

class MagicalCapabilityModelTest extends AbstractModelTest
{

    /**
     * Returns an array with the name of all valid Fields
     * @return array
     */
    protected function getValidFields()
    {
        return ['id', 'name'];
    }

    /**
     * The Method used to check if the array is valid
     * @param $array
     * @param bool $withId
     * @return bool
     */
    protected function validationMethod($array, $withId = true)
    {
        return MagicalCapabilityModel::isValidArray($array, $withId);
    }

    /**
     * Returns an Array of Entities, that will be rendered into an Array
     * @return array
     */
    protected function getEntities()
    {
        $entities = [];
        for ($i = 0; $i < 4; $i++) {
            $entity = new MagicalCapability();
            $entity->setName('Konsti'.$i);
            $entity->setId($i);
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
        return MagicalCapabilityModel::toArray($entity);
    }
}