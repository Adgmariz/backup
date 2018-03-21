<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function checkUsuario($nome, $senha){
      return count($this->createQueryBuilder('u')
          ->where('u.nome = :nome')->setParameter('nome', $nome)
          ->andWhere('u.senha = :senha')->setParameter('senha', $senha)
          ->getQuery()
          ->getResult()) > 0;
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :nome')->setParameter('id', $id)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
}
