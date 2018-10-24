<?php
namespace App\Tests;

use App\Entity\Usuario;
use PHPUnit\Framework\TestCase;

class UsuarioTeste extends TestCase{
    public function testAttr(){
        $usuario = new Usuario();
        $usuario->setNome('alexis1');
        $this->assertEquals('alexis1', $usuario->getNome());
    }
}