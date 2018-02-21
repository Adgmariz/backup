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

     public function getNome($nome){
      return $this->nome;
     }

     public function toString(){
       $data = [ 'id' => $this->id,
                'nome'=> $this->nome,
              'senha' => $this->senha];
       return json_encode($data);
     }
}
