<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarefaRepository")
 */
class Tarefa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Usuario")
     */
    private $usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="integer")
     */
    private $ativo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caminho;

    //TODO: DEFAULT NOW() ($data_criacao)

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_criacao;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_alteracao;

    public function getDescricao(){
        return $this->descricao;
    }

    public function setUsuario(Usuario $usuario){
      $this->usuario = $usuario;
    }

    public function getUsuario(){
      return $this->usuario;
    }
}
