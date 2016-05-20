<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\Cyberware;
use CharacterDatabaseBundle\Entity\CyberwareLevel;

class CyberwareModel extends AbstractModel
{

    /**
     * Returns the current Model, as an Array representation, so it can be rendered as JSON.
     * Returns an empty array if the Entity has not the correct class.
     *
     * @param Cyberware $entity
     *
     * @return array
     */
    public static function toArray($entity)
    {
        if ($entity instanceof Cyberware) {
            return [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'description' => $entity->getDescription(),
                'levels' => $entity->getLevels()->map(function (CyberwareLevel $level) {
                    $arr = [
                        'id' => $level->getId(),
                        'level' => $level->getLevel(),
                        'cost' => $level->getCost(),
                        'effect' => $level->getEffect(),
                    ];

                    return $arr;
                })->toArray(),
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
        return ['id', 'name', 'description', 'levels'];
    }
}
