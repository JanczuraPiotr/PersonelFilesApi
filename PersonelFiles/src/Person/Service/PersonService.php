<?php
namespace App\Person\Service;

use App\Person\Entity\Person;
use App\Person\Repository\PersonRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonService
{
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function createPerson(Person $person): Person
    {
        $this->personRepository->save($person);

        return $person;
    }

    public function getById(int $id): ?Person
    {
        return $this->personRepository->findById($id);
    }

    public function updatePerson(Person $person, array $data): Person
    {
        $this->personRepository->save($person);

        return $person;
    }

    public function deletePerson(int $id): void
    {
        $person = $this->personRepository->find($id);
        if ($person) {
            $this->personRepository->delete($person);
        }
    }
}