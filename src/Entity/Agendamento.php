<?php

namespace App\Entity;

use App\Entity\Tarefa;
use App\Entity\Usuario;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgendamentoRepository")
 */
class Agendamento
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_tarefa")
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarefa")
     */
    private $tarefa;

    /**
     * @ORM\Column(name="id_usuario")
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario")
     */
    private $usuario;

    /**
     * @ORM\Column(type="integer")
     */
    private $frequencia;

    public function toString(){
        $data = [ 'id' => $this->id,
                 'tarefa'=> $this->tarefa,
               'usuario' => $this->usuario];
        return json_encode($data);
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

    /**
     * Get the value of tarefa
     */
    public function getTarefa()
    {
        return $this->tarefa;
    }

    /**
     * Set the value of tarefa
     *
     * @return  self
     */
    public function setTarefa($tarefa)
    {
        $this->tarefa = $tarefa;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of frequencia
     */
    public function getFrequencia()
    {
        return $this->frequencia;
    }

    /**
     * Set the value of frequencia
     *
     * @return  self
     */
    public function setFrequencia($frequencia)
    {
        $this->frequencia = $frequencia;

        return $this;
    }
}
