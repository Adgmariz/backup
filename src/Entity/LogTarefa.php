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
     * @ORM\ManyToOne(targetEntity="App\Entity\Agendamento")
     */
    private $agendamento;

    /**
     * @ORM\Column(type="blob")
     */
    private $log;

}
