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
     *@ORM\Column(name="id_usuario")
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

    /**
     * Set the value of descricao
     *
     * @return  self
     */ 
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of ativo
     */ 
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set the value of ativo
     *
     * @return  self
     */ 
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get the value of caminho
     */ 
    public function getCaminho()
    {
        return $this->caminho;
    }

    /**
     * Set the value of caminho
     *
     * @return  self
     */ 
    public function setCaminho($caminho)
    {
        $this->caminho = $caminho;

        return $this;
    }

    /**
     * Get the value of data_criacao
     */ 
    public function getDataCriacao()
    {
        return $this->data_criacao->format('d/m/Y H:i');
    }

    /**
     * Set the value of data_criacao
     *
     * @return  self
     */ 
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = new Datetime($data_criacao);

        return $this;
    }

    /**
     * Get the value of data_alteracao
     */ 
    public function getDataAlteracao()
    {
        return $this->data_alteracao->format('d/m/Y H:i');
    }

    /**
     * Set the value of data_alteracao
     *
     * @return  self
     */ 
    public function setDataAlteracao($data_alteracao)
    {
        $this->data_alteracao = new Datetime($data_alteracao);

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

    public function toString(){
        return $this->id;
    }
}
