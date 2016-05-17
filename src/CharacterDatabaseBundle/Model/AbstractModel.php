<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

abstract class AbstractModel implements ModelInterface
{
    public static function entityArrayToArray(array $entity)
    {
        $array = [];
        foreach ($entity as $attribute) {
            $array[] = static::toArray($attribute);
        }

        return $array;
    }

    public static function isValidArray(array $array, $withId = true)
    {
        foreach (static::getArrayFields() as $field) {
            if (!$withId && $field == 'id') {
                continue;
            }
            if (!isset($array[$field])) {
                return false;
            }
        }

        return true;
    }
}
