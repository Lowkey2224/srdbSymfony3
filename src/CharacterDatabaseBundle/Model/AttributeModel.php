<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\Attribute;

class AttributeModel extends AbstractModel
{
    /**
     * Returns the current Model, as an Array representation, so it can be rendered as JSON.
     *
     * @return array
     */
    public static function toArray($entity)
    {
        if ($entity instanceof Attribute) {
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
