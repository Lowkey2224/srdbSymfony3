<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

class CharacterControllerTest extends AbstractEntityControllerTest
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    private $jsonEntries = 19;

    public function fieldsForIndexTesting()
    {
        return ['id', 'name', 'user.id', "user.name"];
    }

    protected function getRouteName()
    {
        return '/character';
    }

    private $characterArrayNeil = [
        'name' => 'Neil',
        'race' => 'HSS',
        'description' => 'Kid-Stealth Cyberlegs Guy',
        'descriptionContentType' => 'plain',
        'occupation' => 'Street-Sam',
        'goodKarma' => '0',
        'reputation' => '0',
        'type' => '1',
    ];

    private $characterArrayJose = [
        'name' => 'José',
        'race' => 'HSR',
        'description' => 'Pinoy Troll Schamane',
        'descriptionContentType' => 'plain',
        'occupation' => 'Schamane',
        'goodKarma' => '0',
        'reputation' => '0',
        'type' => '1',
        'capability' => 'Vollmagier',
        'tradition' => 'Schamane',
        'totem' => 'Wildschwein',
    ];

    private $characterArrayLodur = [
        'id' => 1,
        'name' => 'Lodur',
        'race' => 'HSS',
        'description' => 'Lässiger Konzerner mit Chip und Datenbuchsen',
        'descriptionContentType' => 'plain',
        'occupation' => 'Decker/Rigger',
        'goodKarma' => '150',
        'reputation' => '150',
        'type' => '1',
    ];

    private $characterArrayCowboy = [
        'name' => 'Cowboy',
        'race' => 'HSS',
        'description' => 'Unnauffälliger Norm mit weißer Strähne',
        'descriptionContentType' => 'plain',
        'occupation' => 'Util-Mage',
        'goodKarma' => '0',
        'reputation' => '0',
        'type' => '1',
        'capability' => 'Vollmagier',
        'tradition' => 'Hermetiker',
    ];

    private $characterArrayCowboyWithSkills = [
        'name' => 'Cowboy',
        'race' => 'HSS',
        'description' => 'Unnauffälliger Norm mit weißer Strähne',
        'descriptionContentType' => 'plain',
        'occupation' => 'Util-Mage',
        'goodKarma' => '0',
        'reputation' => '0',
        'type' => '1',
        'capability' => 'Vollmagier',
        'tradition' => 'Hermetiker',
        'skill' => [
            'Heimlichkeit' => 3,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testShow()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $chars = $this->em->getRepository('CharacterDatabaseBundle:Character')->findAll();
        $this->assertGreaterThan(0, count($chars));
        for ($i = 0; $i < count($chars) && $i < 10; ++$i) {
            $client->request('GET', '/character/'.$chars[$i]->getId());
            $this->assertTrue(
                $client->getResponse()->headers->contains(
                    'Content-Type',
                    'application/json'
                )
            );
            $this->assertTrue($client->getResponse()->isSuccessful());
            $responseData = json_decode($client->getResponse()->getContent(), true);
            $this->assertCount($this->jsonEntries, $responseData, 'For Character: '.$chars[$i]->getName());
        }
        $this->logout($client);
    }

    public function testShowAnonymously()
    {
        $client = static::createClient();
        $chars = $this->em->getRepository('CharacterDatabaseBundle:Character')->findAll();
        $this->assertGreaterThan(0, count($chars));
        for ($i = 0; $i < count($chars) && $i < 10; ++$i) {
            $client->request('GET', '/character/'.$chars[$i]->getId());
            $this->assertTrue($client->getResponse()->isClientError());
            $this->assertEquals(401, $client->getResponse()->getStatusCode());
        }
    }

    public function testShowWithWrongId()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $client->request('GET', '/character/0');
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->logout($client);
    }

    public function testCreateAnonymously()
    {
        $client = static::createClient();
        $client->request('PUT', '/character');
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCreateWithWrongJson()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $client->request('PUT', '/character', [], [], [], json_encode(['Name' => 'Hallo']));
        $this->assertTrue($client->getResponse()->isClientError(), 'Is not Clienterror');
    }

    public function testCreate()
    {
        $characters = [
            $this->characterArrayCowboy,
            $this->characterArrayJose,
            $this->characterArrayNeil,
        ];
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        foreach ($characters as $char) {
            $client->request('PUT', '/character', [], [], [], json_encode($char));
            $response = $client->getResponse();
            $this->assertTrue(
                $response->isSuccessful(),
                'Is not Successful for Character: '.$char['name'].' with Errorcode: '.
                $response->getStatusCode().' and Body: '.$response->getContent()
            );
            $response = json_decode($response->getContent(), true);
            $this->assertEquals($char['name'], $response['name']);
            $this->assertEquals($char['occupation'], $response['occupation']);
            $this->assertEquals($char['race'], $response['race']);
            $this->assertTrue(isset($response['id']));
        }
        $this->logout($client);
    }

    public function testUpdate()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $char = $this->characterArrayLodur;
        $client->request('PUT', '/character/'.$char['id'], [], [], [], json_encode($char));
        $response = $client->getResponse();
        $this->assertTrue(
            $response->isSuccessful(),
            'Is not Successful for Character: '.$char['name'].' with Errorcode: '.
            $response->getStatusCode().' and Body: '.$response->getContent()
        );
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($char['name'], $response['name']);
        $this->assertEquals($char['description'], $response['description']);
        $this->assertEquals($char['goodKarma'], $response['goodgoodKarma']);
        $this->assertEquals($char['reputation'], $response['reputation']);
        $this->assertEquals($char['id'], $response['id']);
    }

    public function testUpdateWithSkill()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $char = $this->characterArrayCowboyWithSkills;
        $id = $this->em->getRepository('CharacterDatabaseBundle:Character')->findOneBy(
            ['name' => $char['name']]
        )->getId();
        $client->request('PUT', '/character/'.$id, [], [], [], json_encode($char));
        $response = $client->getResponse();
        $this->assertTrue(
            $response->isSuccessful(),
            'Is not Successful for Character: '.$char['name'].' with Errorcode: '.
            $response->getStatusCode().' and Body: '.$response->getContent()
        );
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($char['name'], $response['name']);
        $this->assertEquals($char['description'], $response['description']);
        $this->assertEquals($char['goodKarma'], $response['goodgoodKarma']);
        $this->assertEquals($char['reputation'], $response['reputation']);
        $this->assertArrayHasKey('skills', $response);
        foreach ($char['skill'] as $name => $level) {
            $this->assertEquals(
                1,
                $this->containsSkill(
                    ['name' => $name, 'level' => $level, "type" => "Aktionsfähigkeit"],
                    $response['skills']
                ),
                "Skill Heimlichkeit was Found with a different Count"
            );
        }


        $this->assertEquals($id, $response['id']);
    }

    public function testUpdateWithWrongId()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $char = $this->characterArrayLodur;
        $client->request('PUT', '/character/0', [], [], [], json_encode($char));
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->logout($client);
    }

    private function containsSkill($needle, $haystack)
    {
        $count = 0;
        foreach ($haystack as $skill) {
            if ($skill['name'] == $needle['name'] &&
                $skill['level'] == $needle['level'] &&
                $skill['type'] == $needle['type']
            ) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns an Invalid Array of Items
     * @return array
     */
    protected function getInvalidJson()
    {
        // TODO: Implement getInvalidJson() method.
        return [['Hallo' => 'Welt']];
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
}
