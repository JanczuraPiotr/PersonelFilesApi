<?php

namespace App\Person\Entity;

use App\Person\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PersonRepository extends ServiceEntityRepository
{
    public function __construct(
            ManagerRegistry $registry, 
            )
    {
        parent::__construct($registry, Person::class);
    }

    public function findById($id): ?Person
    {
        return $this->find($id);
    }

    // public function delete(Person $person): void
    // {
    //     $this->personManager->remove($person);
    //     $this->personManager->flush();
    // }
}