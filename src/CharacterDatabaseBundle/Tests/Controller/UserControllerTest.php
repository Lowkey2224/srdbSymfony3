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
        $client->request('GET', '/user');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($responseData));
        for ($i = 0; $i < count($responseData) && $i < 10; ++$i) {
            $this->assertArrayHasKey('id', $responseData[$i]);
            $this->assertArrayHasKey('username', $responseData[$i]);
            $this->assertArrayHasKey('email', $responseData[$i]);
            $this->assertArrayHasKey('character', $responseData[$i]);
        }
    }

    public function testShow()
    {
        $client = static::createClient();
        $users = $this->em->getRepository('CharacterDatabaseBundle:User')->findAll();
        $this->assertGreaterThan(0, count($users));
        for ($i = 0; $i < count($users) && $i < 10; ++$i) {
            $client->request('GET', '/user/'.$users[$i]->getId());
            $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'));
            $userModel = new UserModel($users[$i]);
            $this->assertTrue($client->getResponse()->isSuccessful());
            $responseData = json_decode($client->getResponse()->getContent(), true);
            $this->assertEquals($userModel->toArray(), $responseData, 'For Character: '.$users[$i]->getUsername());
        }
    }
}
