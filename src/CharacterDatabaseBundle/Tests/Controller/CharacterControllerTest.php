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
    }

    public function testShow()
    {
        $client = static::createClient();
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
    }
}
