<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

class TotemControllerTest extends AbstractEntityControllerTest
{
    protected function getRouteName()
    {
        return '/totem';
    }

    /**
     * Returns an Invalid Array of Items
     * @return array
     */
    protected function getInvalidJson()
    {
        return [];
    }

    /**
     * Returns an Array Of Items which can be used for Creation
     * @return array
     */
    protected function getValidCreationJson()
    {
        return [];
    }

    /**
     * Returns an Array of Entity that will be updated.
     * Preferably always n*2 Items, with first one as change, and second one with the original State
     * this array must Contain an ID
     * @return array
     */
    protected function getEntityUpdated()
    {
        return [];
    }

    /**
     * Returns an array of Fields/Keys in dot notation, that will be checked
     * @return array
     */
    protected function fieldsForIndexTesting()
    {
        return ['id', 'name'];
    }
}
