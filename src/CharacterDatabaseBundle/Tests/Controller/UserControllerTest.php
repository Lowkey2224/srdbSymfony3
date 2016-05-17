<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use CharacterDatabaseBundle\Model\UserModel;

class UserControllerTest extends AbstractEntityControllerTest
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public $username = 'Loki';
    public $password = 'wuseldusel';

    public function testedIndexFields()
    {
        return ['id', 'username', 'email', 'character'];
    }

    protected function getRouteName()
    {
        return '/user';
    }

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

    /**
     * @covers CharacterDatabaseBundle\Controller\UserController::showAction()
     */
    public function testShow()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $users = $this->em->getRepository('CharacterDatabaseBundle:User')->findAll();
        $this->assertGreaterThan(0, count($users));
        for ($i = 0; $i < count($users) && $i < 10; ++$i) {
            $client->request('GET', '/user/'.$users[$i]->getId());
            $this->assertTrue($client->getResponse()->isSuccessful(),
                "Request for userId: $users[$i]->getId() is not Successful");
            $this->assertTrue(
                $client->getResponse()->headers->contains('Content-Type', 'application/json'),
                'Request is hast not correct MimeType'
            );
            $responseData = json_decode($client->getResponse()->getContent(), true);
            $this->assertEquals(UserModel::toArray($users[$i]), $responseData,
                'For Character: '.$users[$i]->getUsername());
        }
        $this->logout($client);
    }

    /**
     * @covers CharacterDatabaseBundle\Controller\UserController::showAction()
     */
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
        $this->logout($client);
    }

    /**
     * @covers CharacterDatabaseBundle\Controller\UserController::showAction()
     */
    public function testShowWithWrongId()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $client->request('GET', '/user/0');
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->logout($client);
    }

    /**
     * @covers CharacterDatabaseBundle\Controller\UserController::showAction()
     */
    public function testisLoggedInAction()
    {
        $client = static::createClient();
        $client->request('GET', '/user/loggedIn');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request is not Successful');
        $this->assertTrue(
            $client->getResponse()->headers->contains('Content-Type', 'application/json'),
            'Request is hast not correct MimeType');

        $this->assertFalse(json_decode($client->getResponse()->getContent()));
        $this->loginAs($client, $this->username, $this->password);
        $client->request('GET', '/user/loggedIn');
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request is not Successful');
        $this->assertTrue(
            $client->getResponse()->headers->contains('Content-Type', 'application/json'),
            'Request is hast not correct MimeType'
        );

        $this->assertTrue(json_decode($client->getResponse()->getContent()));
        $this->logout($client);
    }
}
