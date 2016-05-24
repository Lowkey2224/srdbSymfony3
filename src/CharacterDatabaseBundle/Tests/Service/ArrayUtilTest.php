<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Service;

use CharacterDatabaseBundle\Service\ArrayUtil;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase
{
    private $array = [
        'foo' => [
            'bar' => [
                'baz' => 1
            ]
        ]
    ];

    public function testGet()
    {
        $this->assertEquals(1, ArrayUtil::get($this->array, "foo.bar.baz"));
        $this->assertEquals(3, ArrayUtil::get($this->array, "foo.bar.baz.bay", 3));
        $this->assertEquals(3, ArrayUtil::get($this->array, "foo.baz.baz.bay", 3));
    }

    public function testSet()
    {
        ArrayUtil::set($this->array, 'foo.bar.bar', 2);
        $this->assertEquals('2', $this->array['foo']['bar']['bar']);
        $arr = [];
        ArrayUtil::set($arr, 'foo.bar.bar', 2);
        $this->assertEquals('2', $arr['foo']['bar']['bar']);
    }
}
