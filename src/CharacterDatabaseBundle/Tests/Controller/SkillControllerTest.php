<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use CharacterDatabaseBundle\Entity\Skill;

class SkillControllerTest extends AbstractEntityControllerTest
{
    private $skillThrowing = [
        'name' => 'Wurfwaffen',
        'type' => Skill::TYPE_ACTION_SKILL,
        'attribute' => [
            'id' => 2,
            'name' => 'Schnelligkeit',
        ],
    ];

    protected function getRouteName()
    {
        return '/skill';
    }

    public function testCreateAnonymously()
    {
        $client = static::createClient();
        $client->request('PUT', $this->getRouteName());
        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }


    public function testCreateWithWrongJson()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $client->request('PUT', $this->getRouteName(), [], [], [], json_encode(['Name' => 'Hallo']));
        $this->assertTrue($client->getResponse()->isClientError(), 'Is not Clienterror, got Statuscode'. $client->getResponse()->getStatusCode());
    }

    public function testCreate()
    {
        $skills = [
            $this->skillThrowing,
        ];
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        foreach ($skills as $skill) {
            $client->request('PUT', $this->getRouteName(), [], [], [], json_encode($skill));
            $response = $client->getResponse();
            $this->assertTrue(
                $response->isSuccessful(),
                'Is not Successful for Character: '.$skill['name'].' with Errorcode: '.
                $response->getStatusCode().' and Body: '.$response->getContent()
            );
            $response = json_decode($response->getContent(), true);
            $this->assertEquals($skill['name'], $response['name']);
            $this->assertEquals($skill['type'], $response['type']['id']);
            $this->assertEquals($skill['attribute']['id'], $response['attribute']['id']);
            $this->assertTrue(isset($response['id']));
            $this->skillThrowing['id'] = $response['id'];
        }
        $this->logout($client);
    }

    public function testUpdate()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);

        $char = $this->skillThrowing;
        $this->markTestIncomplete("Skill muss gesucht werden");
        $client->request('PUT', $this->getRouteName().$char['id'], [], [], [], json_encode($char));
        $response = $client->getResponse();
        $this->assertTrue(
            $response->isSuccessful(),
            'Is not Successful for Character: '.$char['name'].' with Errorcode: '.
            $response->getStatusCode().' and Body: '.$response->getContent()
        );
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($char['name'], $response['name']);
        $this->assertEquals($char['type'], $response['type']);
        $this->assertEquals($char['attribute']['id'], $response['attribute']['id']);
        $this->assertEquals($char['id'], $response['id']);
    }

    public function testUpdateWithWrongId()
    {
        $client = static::createClient();
        $this->loginAs($client, $this->username, $this->password);
        $char = $this->skillThrowing;
        $client->request('PUT', $this->getRouteName().'/0', [], [], [], json_encode($char));
//        $this->assertTrue($client->getResponse()->isClientError());
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->logout($client);
    }
}
