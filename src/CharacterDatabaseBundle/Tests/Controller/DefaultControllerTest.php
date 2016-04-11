<?php

namespace CharacterDatabaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/');

//        $crawler->count();
        echo "\n".$client->getResponse()->getContent()."\n";
        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
