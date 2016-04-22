<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/character');


        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($responseData));
        $this->assertEquals(17, count($responseData[0]));
    }

    public function testShow()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/character/1');


        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        $this->assertTrue($client->getResponse()->isSuccessful());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(17, count($responseData));
    }
}