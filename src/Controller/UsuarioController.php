<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Usuario;


class UsuarioController extends Controller
{
    /**
     * @Route("/usuario", name="usuario")
     */
    public function index()
    {
      $usuario = $this->getDoctrine()
       ->getRepository(Usuario::class)
       ->checkUsuario('alexis', md5('12345'));
       return new Response(json_encode($usuario));
    }

    ///**
   //* @Route("/usuario/{id}", name="usuario")
   //*/
    /*public function searchById(Usuario $usuario){
      return new Response($usuario->toString());
    }*/

}
