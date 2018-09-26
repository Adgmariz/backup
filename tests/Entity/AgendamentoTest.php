<?php
namespace App\Tests\Entity;

use App\Entity\Agendamento;
use PHPUnit\Framework\TestCase;

class AgendamentoTest extends TestCase{

    private $agendamento;
    public function getAgendamento()
    {
        return $this->agendamento;
    }
    public function setAgendamento($agendamento)
    {
        $this->agendamento = $agendamento;

        return $this;
    }

    /**
     * @before
     */
    public function setUp(){
        $this->setAgendamento(new Agendamento());
        $this->getAgendamento()->setId(1);
        $this->getAgendamento()->setTarefa(1);
        $this->getAgendamento()->setUsuario(1);
        $this->getAgendamento()->setFrequencia(1);
        $this->getAgendamento()->setData_ultima_exec("2018-09-26 18:14");
    }

    public function testAttr(){
      $this->assertClassHasAttribute('id', Agendamento::class);
      $this->assertClassHasAttribute('tarefa', Agendamento::class);
      $this->assertClassHasAttribute('usuario', Agendamento::class);
      $this->assertClassHasAttribute('frequencia', Agendamento::class);
      $this->assertClassHasAttribute('data_ultima_exec', Agendamento::class);
    }

    public function testGetTimeToadd(){
        $this->getAgendamento()->setFrequencia(1);
        $this->assertEquals($this->getAgendamento()->getFrequencia() * 10,$this->getAgendamento()->getTimeToAdd());

        $this->getAgendamento()->setFrequencia(2);
        $this->assertEquals($this->getAgendamento()->getFrequencia() * 10,$this->getAgendamento()->getTimeToAdd());

        $this->getAgendamento()->setFrequencia(3);
        $this->assertEquals($this->getAgendamento()->getFrequencia() * 10,$this->getAgendamento()->getTimeToAdd());

        $this->getAgendamento()->setFrequencia(0);
        $this->assertEquals(0,$this->getAgendamento()->getTimeToAdd());
    }
}
