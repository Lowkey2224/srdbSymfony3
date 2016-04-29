<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    private $jsonEntries = 18;

    private $username = 'Loki';
    private $password = 'wuseldusel';

    private $characterArrayNeil = [
        'name' => 'Neil',
        'race' => 'HSS',
        'description' => 'Kid-Stealth Cyberlegs Guy',
        'occupation' => 'Street-Sam',
        'goodKarma' => '0',
        'reputaion' => '0',
        'type' => 'SC',
    ];

    private $characterArrayJose = [
        'name' => 'José',
        'race' => 'HSR',
        'description' => 'Pinoy Troll Schamane',
        'occupation' => 'Schamane',
        'goodKarma' => '0',
        'reputaion' => '0',
        'type' => 'SC',
        'magical' => 'Vollmagier',
        'tradition' => 'Schamane',
        'totem' => 'Wildschwein',
    ];

    private $characterArrayLodur = [
        'id' => 1,
        'name' => 'Lodur',
        'race' => 'HSS',
        'description' => 'Lässiger Konzerner mit Chip und Datenbuchsen',
        'occupation' => 'Decker/Rigger',
        'goodKarma' => '150',
        'reputaion' => '150',
        'type' => 'SC',
    ];

    private $characterArrayCowboy = [
        'name' => 'Cowboy',
        'race' => 'HSS',
        'description' => 'Unnauffälliger Norm mit weißer Strähne',
        'occupation' => 'Util-Mage',
        'goodKarma' => '0',
        'reputaion' => '0',
        'type' => 'SC',
        'magical' => 'Vollmagier',
        'tradition' => 'Hermetiker',
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

    public function testIndex()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
        $client->request('GET', '/character');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($responseData));
        $this->assertEquals($this->jsonEntries, count($responseData[0]));
        TestUtils::logout($client);
    }

    public function testIndexAnonymously()
    {
        $client = static::createClient();
        $client->request('GET', '/character');
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertContains('login', $client->getRequest()->getUri(),
            'Es wurde nicht auf die Login Seite weitergeleitet');
    }

    public function testShow()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
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
            $this->assertEquals($this->jsonEntries, count($responseData), 'For Character: '.$chars[$i]->getName());
        }
        TestUtils::logout($client);
    }

    public function testShowAnonymously()
    {
        $client = static::createClient();
        $chars = $this->em->getRepository('CharacterDatabaseBundle:Character')->findAll();
        $this->assertGreaterThan(0, count($chars));
        for ($i = 0; $i < count($chars) && $i < 10; ++$i) {
            $client->request('GET', '/character/'.$chars[$i]->getId());
            $this->assertTrue($client->getResponse()->isRedirect());
            $client->followRedirect();
            $this->assertContains('login', $client->getRequest()->getUri(),
                'Es wurde nicht auf die Login Seite weitergeleitet');
        }
    }

    public function testCreateAnonymously()
    {
        $client = static::createClient();
        $client->request('PUT', '/character');
        $this->assertTrue($client->getResponse()->isRedirect(), 'Is not Redirect');
        $client->followRedirect();
        $this->assertContains('login', $client->getRequest()->getUri(),
            'Es wurde nicht auf die Login Seite weitergeleitet');
    }

    public function testCreateWithWrongJson()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
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
        TestUtils::loginAs($client, $this->username, $this->password);
        foreach ($characters as $char) {
            $client->request('PUT', '/character', [], [], [], json_encode($char));
            $response = $client->getResponse();
            $this->assertTrue($response->isSuccessful(),
                'Is not Successful for Character: '.$char['name'].' with Errorcode: '.$response->getStatusCode().' and Body: '.$response->getContent());
            $response = json_decode($response->getContent(), true);
            $this->assertEquals($char['name'], $response['name']);
            $this->assertEquals($char['occupation'], $response['occupation']);
            $this->assertEquals($char['race'], $response['race']);
            $this->assertTrue(isset($response['id']));
        }
        TestUtils::logout($client);
    }

    public function testUpdate()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
        $char = $this->characterArrayLodur;
        $client->request('PUT', '/character/'.$char['id'], [], [], [], json_encode($char));
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful(),
                'Is not Successful for Character: '.$char['name'].' with Errorcode: '.$response->getStatusCode().' and Body: '.$response->getContent());
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($char['name'], $response['name']);
        $this->assertEquals($char['description'], $response['description']);
        $this->assertEquals($char['goodKarma'], $response['goodKarma']);
        $this->assertEquals($char['reputaion'], $response['reputaion']);
        $this->assertEquals($char['id'], $response['id']);
    }
}
