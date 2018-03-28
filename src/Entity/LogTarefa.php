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
     * @ORM\Column(type="blob")
     */
    private $log;

    public function getAgendamento(){
      return $this->agendamento;
    }

    public function setAgendamento(Agendamento $agendamento){
      $this->agendamento = $agendamento;
    }

}
