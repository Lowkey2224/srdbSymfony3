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

    public $username = 'Loki';
    public $password = 'wuseldusel';

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
}
