<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;

class TestUtils
{
    public static function loginAs(Client $client, $user = 'Loki', $pass = 'wuseldusel')
    {
        $crawler = $client->request('GET', '/login');
        $btn = $crawler->selectButton('Anmelden');
        $form = $btn->form([
            '_username' => $user,
            '_password' => $pass,
        ]);
        $client->submit($form);
        \PHPUnit_Framework_Assert::assertTrue($client->getResponse()->isRedirect(), 'Request is not Successful');
    }

    public static function logout(Client $client)
    {
        $client->request('GET', '/logout');
        \PHPUnit_Framework_Assert::assertTrue($client->getResponse()->isRedirect(), 'Request is not Successful');
    }
}
