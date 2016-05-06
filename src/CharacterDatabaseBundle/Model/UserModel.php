<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\User;

class UserModel extends AbstractModel
{
    /**
     * Returns the Fieldnames in the array as an array.
     *
     * @return array
     */
    public static function getArrayFields()
    {
        return ['id', 'username', 'email', 'character'];
    }

    /**
     * Returns the current Model, as an Array representation, so it can be rendered as JSON.
     *
     * @return array
     */
    public static function toArray($entity)
    {
        if ($entity instanceof User) {
            return [
                'id' => $entity->getId(),
                'username' => $entity->getUsername(),
                'email' => $entity->getEmail(),
                'character' => $entity->getCharacters()->map(function (Character $char) {
                    return ['id' => $char->getId()];
                })->toArray(),

            ];
        }

        return [];
    }
}
