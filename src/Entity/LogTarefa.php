<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogTarefaRepository")
 */
class LogTarefa
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_agendamento")
     * @ORM\ManyToOne(targetEntity="App\Entity\Agendamento")
     */
    private $agendamento;

    /**
     * @ORM\Column(name="id_tarefa")
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarefa")
     */
    private $tarefa;

    /**
     * @ORM\Column(type="blob")
     */
    private $log;

    public function getAgendamento(){
      return $this->agendamento;
    }

    public function setAgendamento($agendamento){
      $this->agendamento = $agendamento;
    }

    public function getTarefa(){
        return $this->tarefa;
    }

    public function setTarefa($tarefa){
        $this->tarefa = $tarefa;
    }

    /**
     * Get the value of log
     */ 
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set the value of log
     *
     * @return  self
     */ 
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
