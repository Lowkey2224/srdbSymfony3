<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

interface ModelInterface
{
    /**
     * Returns the current Model, as an Array representation, so it can be rendered as JSON.
     * Returns an empty array if the Entity has not the correct class.
     *
     * @param $entity
     *
     * @return array
     */
    public static function toArray($entity);

    /**
     * Returns the Fieldnames in the array as an array.
     *
     * @return array
     */
    public static function getArrayFields();

    /**
     * Converts the given array of Entities to an array with its Model representation.
     *
     * @param array $entity
     *
     * @return array
     */
    public static function entityArrayToArray(array $entity);

    /**
     * Checks if the Array is sufficient for this Model Class.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isValidArray(array $array);
}
