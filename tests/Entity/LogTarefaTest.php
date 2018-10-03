<?php
namespace App\Tests\Entity;

use App\Entity\LogTarefa;
use PHPUnit\Framework\TestCase;

class LogTarefaTest extends TestCase{

    private $logTarefa;
    public function getLogTarefa()
    {
        return $this->logTarefa;
    }
    public function setLogTarefa($logTarefa)
    {
        $this->logTarefa = $logTarefa;

        return $this;
    }

    /**
     * @before
     */
    public function setUp(){
        $this->setLogTarefa(new LogTarefa());
        $this->getLogTarefa()->setId(1);
        $this->getLogTarefa()->setAgendamento(1);
        $this->getLogTarefa()->setTarefa(1);
        $this->getLogTarefa()->setLog('log teste');
    }

    public function testAttr(){
        $this->assertClassHasAttribute('id', LogTarefa::class);
        $this->assertClassHasAttribute('agendamento', LogTarefa::class);
        $this->assertClassHasAttribute('tarefa', LogTarefa::class);
        $this->assertClassHasAttribute('log', LogTarefa::class);
    }

}
