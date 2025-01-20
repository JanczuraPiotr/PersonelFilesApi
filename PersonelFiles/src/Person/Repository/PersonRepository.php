<?php

namespace App\Person\Repository;

use App\Person\Entity\Person;
use App\Person\Service\PersonDbManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PersonRepository extends ServiceEntityRepository
{
    private $personManager;

    public function __construct(ManagerRegistry $registry, PersonDbManager $personManager)
    {
        parent::__construct($registry, Person::class);
        $this->personManager = $personManager;
    }

    public function findById($id): ?Person
    {
        return $this->find($id);
    }

    public function save(Person $person): void
    {
        $this->personManager->save($person);
    }

    // public function delete(Person $person): void
    // {
    //     $this->personManager->remove($person);
    //     $this->personManager->flush();
    // }
}