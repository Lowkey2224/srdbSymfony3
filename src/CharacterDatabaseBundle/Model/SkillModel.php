<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\Skill;

class SkillModel extends AbstractModel
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
        if ($entity instanceof Skill) {
            return [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'type' => [
                    "id" => $entity->getType(),
                    "name" => $entity->getTypeName(),
                    ],
                'attribute' => AttributeModel::toArray($entity->getAttribute()),
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
        return ['id', 'name', 'attribute'];
    }
}
