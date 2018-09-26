<?php
namespace App\Tests\Entity;

use App\Entity\Tarefa;
use PHPUnit\Framework\TestCase;

class TarefaTest extends TestCase{

    private $tarefa;
    public function getTarefa()
    {
        return $this->tarefa;
    }
    public function setTarefa($tarefa)
    {
        $this->tarefa = $tarefa;

        return $this;
    }

    /**
     * @before
     */
    public function setUp(){
        $this->setTarefa(new Tarefa());
        $this->getTarefa()->setId(1);
        $this->getTarefa()->setUsuario(1);
        $this->getTarefa()->setDescricao('descricao1');
        $this->getTarefa()->setAtivo(1);
        $this->getTarefa()->setCaminho('path/caminho');
        $this->getTarefa()->setDataCriacao("2018-09-26 18:14");
        $this->getTarefa()->setDataAlteracao("2018-09-26 18:14");
    }

    public function testAttr(){
      $this->assertClassHasAttribute('id', Tarefa::class);
      $this->assertClassHasAttribute('usuario', Tarefa::class);
      $this->assertClassHasAttribute('descricao', Tarefa::class);
      $this->assertClassHasAttribute('ativo', Tarefa::class);
      $this->assertClassHasAttribute('caminho', Tarefa::class);
      $this->assertClassHasAttribute('data_criacao', Tarefa::class);
      $this->assertClassHasAttribute('data_alteracao', Tarefa::class);
    }

    public function testGetDataCriacao(){
        $this->assertEquals($this->getTarefa()->getDataCriacao(),"26/09/2018 18:14");
    }
    public function testGetDataAlteracao(){
        $this->assertEquals($this->getTarefa()->getDataAlteracao(),"26/09/2018 18:14");
    }

}
