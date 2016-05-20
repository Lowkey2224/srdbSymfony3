<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use CharacterDatabaseBundle\Service\ArrayUtil;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

abstract class AbstractEntityControllerTest extends WebTestCase
{
    protected $username = 'Loki';
    protected $password = 'wuseldusel';

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
            foreach ($responseData as $item) {
                foreach ($this->fieldsForIndexTesting() as $field) {
                    $this->assertNotNull(
                        ArrayUtil::get($item, $field),
                        "Array has not key ".$field." only ".implode(", ", array_keys($item))
                    );
                }
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

    public function testCreateAnonymously()
    {
        $client = static::createClient();
        foreach ($this->getValidCreationJson() as $entity) {
            $client->request('PUT', $this->getRouteName(), [], [], [], json_encode($entity));
            $this->assertTrue($client->getResponse()->isClientError());
            $this->assertEquals(401, $client->getResponse()->getStatusCode());
        }
    }

    public function testCreateWithWrongJson()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        foreach ($this->getInvalidJson() as $invalidJson) {
            $client->request('PUT', $this->getRouteName(), [], [], [], json_encode($invalidJson));
            $this->assertTrue(
                $client->getResponse()->isClientError(),
                'Is not Clienterror, got Statuscode'.$client->getResponse()->getStatusCode()
            );
        }
    }

    public function testCreate()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        foreach ($this->getValidCreationJson() as $entity) {
            $client->request('PUT', $this->getRouteName(), [], [], [], json_encode($entity));
            $response = $client->getResponse();
            $this->assertTrue(
                $response->isSuccessful(),
                'Is not Successful for Character: '.$entity['name'].' with Errorcode: '.
                $response->getStatusCode().' and Body: '.$response->getContent()." and jsonbody ".json_encode($entity)
            );
            $response = json_decode($response->getContent(), true);
            foreach ($this->fieldsForIndexTesting() as $field) {
                $this->assertEquals(
                    ArrayUtil::get($entity, $field),
                    ArrayUtil::get($response, $field),
                    "Field ".$field."  is different"
                );
            }

        }
        $this->logout($client);
    }

    public function testUpdate()
    {
        foreach ($this->getEntityUpdated() as $entity) {
            $client = static::createClient();
            $this->loginAs($client, $this->username, $this->password);
            $client->request(
                'PUT',
                $this->getRouteName().'/'.$entity['id'],
                [],
                [],
                [],
                json_encode($entity)
            );
            $response = $client->getResponse();

            $this->assertTrue(
                $response->isSuccessful(),
                'Is not Successful for Skill: '.ArrayUtil::get($entity, 'name').' with Errorcode: '.
                $response->getStatusCode().' and Body: '.$response->getContent()
            );
            $response = json_decode($response->getContent(), true);
            foreach ($this->fieldsForIndexTesting() as $field) {
                $this->assertEquals(
                    ArrayUtil::get($entity, $field),
                    ArrayUtil::get($response, $field),
                    "Field ".$field."  is different"
                );
            }
            $this->assertEquals($entity['id'], $response['id']);
        }

    }

    public function testUpdateWithWrongId()
    {

        foreach ($this->getValidCreationJson() as $skill) {
            $client = static::createClient();
            $this->loginAs($client, $this->username, $this->password);
            $client->request('PUT', $this->getRouteName().'/0', [], [], [], json_encode($skill));
            $this->assertEquals(404, $client->getResponse()->getStatusCode());
            $this->logout($client);
        }

    }

    /**
     * Returns an Invalid Array of Items
     * @return array
     */
    protected abstract function getInvalidJson();

    /**
     * Returns an Array Of Items which can be used for Creation
     * @return array
     */
    protected abstract function getValidCreationJson();

    /**
     * Returns an Array of Entity that will be updated.
     * Preferably always n*2 Items, with first one as change, and second one with the original State
     * this array must Contain an ID
     * @return array
     */
    protected abstract function getEntityUpdated();

    /**
     * Returns the name of the Route which will be used for this Entitytest
     * @return string
     */
    protected abstract function getRouteName();

    /**
     * Returns an array of Fields/Keys in dot notation, that will be checked
     * @return array
     */
    protected abstract function fieldsForIndexTesting();
}
