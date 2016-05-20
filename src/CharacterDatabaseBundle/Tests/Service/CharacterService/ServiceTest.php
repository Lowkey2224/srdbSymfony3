<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Service\CharacterService;

use CharacterDatabaseBundle\Service\CharacterService\Service;
use Symfony\Bridge\Monolog\Logger;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    private $validJsonFields = [
        'name',
        'race',
        'occupation',
        'description',
        'karma',
        'reputation',
        'type',
//        'magical',
//        'tradition',
//        'totem',
    ];
    /**
     * @var Service
     */
    private $service;
    
    public function setUp()
    {
        $this->service = new Service(new Logger("Testlogger"));
        parent::setUp();
    }

    public function testValidateJson()
    {
        $arr1 = [];
        $this->assertFalse($this->service->validateJson($arr1));
        foreach ($this->validJsonFields as $field) {
            $arr1[$field] = 1;
            $result = count($arr1) == count($this->validJsonFields);
            $this->assertEquals(
                $result,
                $this->service->validateJson($arr1),
                "Asserted that: ".implode(",", $arr1)."was ".($result) ? "valid" : "invalid"
            );
        }
        foreach ($this->validJsonFields as $field) {
            unset($arr1[$field]);
            $this->assertFalse(
                $this->service->validateJson($arr1),
                "Asserted that: ".implode(",", $arr1)."was invalid"
            );
        }
    }
}
