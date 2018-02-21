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

    //TODO: DEFAULT 1 ($ativo)

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
}
