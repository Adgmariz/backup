<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
     private $nome;

     /**
     * @ORM\Column(type="string", length=255)
     */
     private $senha;

     public function setNome($nome){
      $this->nome = $nome;
     }

     public function getNome(){
      return $this->nome;
     }

     public function setId($id){
       $this->id = $id;
     }

     public function getId(){
       return $this->id;
     }

     public function setSenha($senha){
       $this->senha = $senha;
     }

     public function getSenha(){
       return $this->senha;
     }

     public function toString(){
       $data = ['nome'=> $this->nome,
                'senha' => $this->senha];
       return json_encode($data);
     }
}
