<?php

namespace AmoussouBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testFestivalier()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/festivalier');
    }

}
