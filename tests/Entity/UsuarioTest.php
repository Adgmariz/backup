<?php
namespace App\Tests\Entity;

use App\Entity\Usuario;
use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase{

    public function testAttr(){
      $this->assertClassHasAttribute('id', Usuario::class);
      $this->assertClassHasAttribute('nome', Usuario::class);
      $this->assertClassHasAttribute('senha', Usuario::class);
    }


    public function testGetNome(){
        $usuario = new Usuario();
        $usuario->setNome('alexis1');
        $this->assertEquals('alexis1', $usuario->getNome());
    }/*
    public function testToString(){
      $usuario = new Usuario();
      $usuario->setId(1);
      $usuario->setNome("nome");
      $usuario->setSenha(md5("senha"));
      $toString = $usuario->toString();
      $jsonDecoded = json_decode($toString, true); //retorna um array
      var_dump(count($toString));exit;
      $this->assertTrue(count($toString) > 0);
      $this->assertArrayHasKey("nome", $jsonDecoded);
      $this->assertArrayHasKey("senha", $jsonDecoded);
      $publicKeys = ["nome", "senha"];
      $keys = array_keys($jsonDecoded);
      $this->assertEmpty(array_diff($publicKeys, $keys));
    }*/
}
