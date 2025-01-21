<?php
namespace App\Person\Entity;

use App\Core\Exception\ConstraintException;
use App\Person\Entity\Person;
use App\Person\Entity\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class PersonManager
{
    public function __construct(
            private PersonRepository $personRepository,
            private EntityManagerInterface $entityManager, 
            private ValidatorInterface $validator)
    {
    }

    public function createPerson(Person $person)
    {
        $this->validate($person);

        $this->entityManager->persist($person);
        $this->entityManager->flush();
    }

    public function findOneById(int $id) : ?Person {
        return $this->personRepository->find($id);
    }

    private function validate(Person $person)
    {
        $violations = $this->validator->validate($person);
        if (count($violations) > 0) {
            throw new ConstraintException(Person::class, $violations);
        }
    }
}