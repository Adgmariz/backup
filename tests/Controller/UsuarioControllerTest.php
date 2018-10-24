<?php
namespace App\Tests\Entity;

use App\Controller\UsuarioController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsuarioControllerTest extends WebTestCase{

    public function testAllUrls(){
        $urls = ['/usuario'];
        $client = static::createClient();

        foreach ($urls as $url) {
            $client->request('GET', $url);
            // $this->assertEquals(200, $client->getResponse()->getStatusCode());
         }
         //var_dump($client->getResponse());
    }

}
