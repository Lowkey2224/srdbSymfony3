<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Models;

use CharacterDatabaseBundle\Entity\NamedEntity;

abstract class AbstractModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Returns an array with the name of all valid Fields
     * @return array
     */
    abstract protected function getValidFields();

    /**
     * The Method used to check if the array is valid
     * @param $array
     * @param bool $withId
     * @return bool
     */
    abstract protected function validationMethod($array, $withId = true);

    /**
     * Returns an Array of Entities, that will be rendered into an Array
     * @return array
     */
    abstract protected function getEntities();

    /**
     * Renders the given Entity into an Array
     * @param $entity
     * @return array
     */
    abstract protected function toArrayMethod($entity);

    public function testValidArray()
    {
        $arr1 = [];
        $this->assertFalse($this->validationMethod($arr1));
        foreach ($this->getValidFields() as $field) {
            $arr1[$field] = 1;
            $result = count($arr1) == count($this->getValidFields());
            $this->assertEquals(
                $result,
                $this->validationMethod($arr1),
                "Asserted that: ".implode(",", $arr1)."was ".($result) ? "valid" : "invalid"
            );
        }
        foreach ($this->getValidFields() as $field) {
            unset($arr1[$field]);
            $this->assertFalse(
                $this->validationMethod($arr1),
                "Asserted that: ".implode(",", $arr1)."was invalid"
            );
        }
    }

    public function testToArray()
    {
        /**
         * @var NamedEntity $entity
         */
        foreach ($this->getEntities() as $entity) {
            $array = $this->toArrayMethod($entity);
            $this->assertTrue($this->validationMethod($array));
            foreach ($this->getValidFields() as $field) {
                $this->assertEqualAttribute($field, $array[$field], $entity);
            }
        }
    }

    /**
     * Method which checks if the array Value of $arrayField and $entity->$fieldName are equal.
     * Override this if you need special checks
     * @param $fieldName
     * @param $arrayField
     * @param NamedEntity $entity
     */
    protected function assertEqualAttribute($fieldName, $arrayField, $entity)
    {
        $methodName = "get".strtoupper(substr($fieldName, 0, 1)).substr($fieldName, 1);
        $this->assertEquals(
            $entity->$methodName(),
            $arrayField,
            "Expected for Entity".$entity->getName().' with method '.$methodName
        );
    }
}
