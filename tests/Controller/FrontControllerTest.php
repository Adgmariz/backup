<?php
namespace App\Tests\Entity;

use App\Controller\FrontController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends WebTestCase{

    public function testAllUrls(){
        $urls = ['/', '/dashboard', '/login', '/logout', '/listaragendamentos', '/editaragendamentos/1', '/processaeditagend', '/excluiragendamento/1',
                '/processacriaragend', '/listartarefas', '/criartarefa', '/processacriartarefa', '/executartarefa/1','/editartarefas/1', '/processaeditatarefa', 
                '/excluirtarefa/1', '/ajax/executar/1', 'processaagendamentos' ];
        $client = static::createClient();

        foreach ($urls as $url) {
            $client->request('GET', $url);
            $this->assertContains($client->getResponse()->getStatusCode(), [200, 302, 500]);
        }
    }

}
