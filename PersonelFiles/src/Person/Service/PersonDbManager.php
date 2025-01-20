<?php
namespace App\Person\Service;

use App\Core\Exception\ConstraintException;
use App\Person\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class PersonDbManager
{
    private $entityManager;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function save(Person $person)
    {
        $this->validate($person);

        $this->entityManager->persist($person);
        $this->entityManager->flush();
    }

    private function validate(Person $person)
    {
        $violations = $this->validator->validate($person);
        if (count($violations) > 0) {
            throw new ConstraintException(Person::class, $violations);
        }
    }
}