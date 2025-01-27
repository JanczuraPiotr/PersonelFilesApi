<?php
namespace App\Person\Service;

use App\Person\Entity\Person;
use App\Person\Entity\PersonManager;
use App\Person\Entity\PersonRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonService
{
    public function __construct(
        private PersonManager $personManager)
    {
    }

    public function createPerson(Person $person): Person
    {
        $this->personManager->createPerson($person);

        return $person;
    }

    public function getAll(): array
    {
        return $this->personManager->getAll();
    }

    // public function getById(int $id): ?Person
    // {
    //     return $this->personRepository->findById($id);
    // }

    // public function updatePerson(Person $person, array $data): Person
    // {
    //     $this->personManager->save($person);

    //     return $person;
    // }

    // public function deletePerson(int $id): void
    // {
    //     $person = $this->personRepository->find($id);
    //     if ($person) {
    //         $this->personRepository->delete($person);
    //     }
    // }
}