<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service;

class CharacterService
{
    /**
     * Checks if the associative array is a valid Character.
     *
     * @param $json
     *
     * @return bool
     */
    public function validateJson($json)
    {
        if (!isset($json['name'])) {
            return false;
        }
        if (!isset($json['race'])) {
            return false;
        }
        if (!isset($json['occupation'])) {
            return false;
        }
        if (!isset($json['description'])) {
            return false;
        }
        if (!isset($json['goodKarma'])) {
            return false;
        }
        if (!isset($json['reputaion'])) {
            return false;
        }
        if (!isset($json['type'])) {
            return false;
        }
        if (isset($json['magical']) && isset($json['tradition']) && $json['tradition'] == '') {
            if (!isset($json['totem'])) {
                return false;
            }
        }

        return true;
    }
}
