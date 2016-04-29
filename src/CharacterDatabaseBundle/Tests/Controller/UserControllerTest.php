<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use CharacterDatabaseBundle\Model\UserModel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

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

    public function testIndexAnonymously()
    {
        $client = static::createClient();
        $client->request('GET', '/user');
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
        $client->request('GET', '/user');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request is not Successful');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ), 'Request is hast not correct MimeType'
        );
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($responseData));
        for ($i = 0; $i < count($responseData) && $i < 10; ++$i) {
            $this->assertArrayHasKey('id', $responseData[$i]);
            $this->assertArrayHasKey('username', $responseData[$i]);
            $this->assertArrayHasKey('email', $responseData[$i]);
            $this->assertArrayHasKey('character', $responseData[$i]);
        }
        TestUtils::logout($client);
    }

    public function testShow()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
        $users = $this->em->getRepository('CharacterDatabaseBundle:User')->findAll();
        $this->assertGreaterThan(0, count($users));
        for ($i = 0; $i < count($users) && $i < 10; ++$i) {
            $client->request('GET', '/user/'.$users[$i]->getId());
            $this->assertTrue($client->getResponse()->isSuccessful(), 'Request is not Successful');
            $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'),
                'Request is hast not correct MimeType');
            $userModel = new UserModel($users[$i]);
            $responseData = json_decode($client->getResponse()->getContent(), true);
            $this->assertEquals($userModel->toArray(), $responseData, 'For Character: '.$users[$i]->getUsername());
        }
        TestUtils::logout($client);
    }

    public function testShowAnonymously()
    {
        $client = static::createClient();
        $users = $this->em->getRepository('CharacterDatabaseBundle:User')->findAll();
        $this->assertGreaterThan(0, count($users));
        for ($i = 0; $i < count($users) && $i < 10; ++$i) {
            $client->request('GET', '/user/'.$users[$i]->getId());
            $this->assertTrue($client->getResponse()->isClientError());
            $this->assertEquals(401, $client->getResponse()->getStatusCode());
        }
        TestUtils::logout($client);
    }
}
