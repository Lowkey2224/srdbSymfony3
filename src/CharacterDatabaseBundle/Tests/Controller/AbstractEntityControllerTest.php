<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

abstract class AbstractEntityControllerTest extends WebTestCase
{
    protected $username = 'Loki';
    protected $password = 'wuseldusel';

    abstract protected function getRouteName();

    public function testedIndexFields()
    {
        return ['id', 'name'];
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
        $this->loginAs($client, $this->username, $this->password);
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
            foreach ($this->testedIndexFields() as $field) {
                $this->assertArrayHasKey($field, $responseData[$i], 'Only has Keys: '.implode(', ', array_keys($responseData[$i])));
            }
        }
        $this->logout($client);
    }

    public function loginAs(Client $client, $user = 'Loki', $pass = 'wuseldusel')
    {
        $crawler = $client->request('GET', '/login');
        $btn = $crawler->selectButton('Anmelden');
        $form = $btn->form([
            '_username' => $user,
            '_password' => $pass,
        ]);
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect(), 'Request is not Successful');
    }

    public function logout(Client $client)
    {
        $client->request('GET', '/logout');
        $this->assertTrue($client->getResponse()->isRedirect(), 'Request is not Successful');
    }
}
