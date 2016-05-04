<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractEntityControllerTest extends WebTestCase
{
    protected $username = 'Loki';
    protected $password = 'wuseldusel';

    abstract protected function getRouteName();

    protected function additionalFields()
    {
        return [];
    }

    public function testIndexAnonymously()
    {
        $client = static::createClient();
        $client->request('GET', $this->getRouteName());
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testIndex()
    {
        $client = static::createClient();
        TestUtils::loginAs($client, $this->username, $this->password);
        $client->request('GET', $this->getRouteName());
        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request is not Successful');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'Request is hast not correct MimeType'
        );
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertGreaterThan(1, count($responseData));
        for ($i = 0; $i < count($responseData) && $i < 10; ++$i) {
            $this->assertArrayHasKey('id', $responseData[$i]);
            $this->assertArrayHasKey('name', $responseData[$i]);
            foreach ($this->additionalFields() as $field) {
                $this->assertArrayHasKey($field, $responseData[$i]);
            }
        }
        TestUtils::logout($client);
    }
}
