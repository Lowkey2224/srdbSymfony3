<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\MagicalTradition;

class MagicalTraditionModel extends AbstractModel
{
    /**
     * Returns the current Model, as an Array representation, so it can be rendered as JSON.
     * Returns an empty array if the Entity has not the correct class.
     *
     * @param object $entity the entity you want to convert
     *
     * @return array
     */
    public static function toArray($entity)
    {
        if ($entity instanceof MagicalTradition) {
            return [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
            ];
        }

        return [];
    }

    /**
     * Returns the Fieldnames in the array as an array.
     *
     * @return array
     */
    public static function getArrayFields()
    {
        return ['id', 'name'];
    }
}
