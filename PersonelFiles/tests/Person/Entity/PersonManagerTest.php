<?php
namespace App\Tests\Person\Entity;

use App\Core\Exception\ConstraintException;
use App\Person\Entity\Person;
use App\Person\Entity\PersonManager;
use App\Person\Entity\PersonRepository;
use App\Tests\Person\Pattern\PersonPattern;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonManagerTest extends KernelTestCase
{
    const NOT_EXISTING_PERSON_ID = 123;

    private static $connection;
    private static PersonManager $personManager;

     public static function setUpBeforeClass(): void
     {
        parent::setUpBeforeClass();
        $kernel = self::bootKernel();
        $it = new self();

        $personRepository = $it->createMock(PersonRepository::class);
        $entityManager = $it->createMock(EntityManager::class);

        $validator = $kernel->getContainer()
            ->get('test.service_container')
            ->get('validator');

        self::$personManager = new PersonManager($personRepository, $entityManager, $validator);        
    }

    public function testNotFountPerson()
    {
        $person = self::$personManager->findOneById(self::NOT_EXISTING_PERSON_ID);
        $this->assertNull($person);
    }

    public function test_CreatePerson_Correct()
    {
        $this->markTestIncomplete("Przebudowa PersonService, PersonManager, PersonRepository");
        // $person = PersonPattern::getPerson1();
        // $this->assertNull($person->getId());

        // $newPerson = self::$personManager->createPerson($person);
     
        // $this->assertNotNull($newPerson->getId());
    }

   public function test_CreatePerson_All_ToShort()
   {
    $person = PersonPattern::getPerson1();
    $person->setName(PersonPattern::Name_ToShort);
    $person->setSurname(PersonPattern::Surname_ToShort);
    $person->setPersonalId(PersonPattern::PersonalId_ToShort);

    $this->assertNull($person->getId());

    try {
        self::$personManager->createPerson($person);
        $this->fail('Exception should be thrown.');
    } catch (ConstraintException $e) {
        $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
        $constraints = $e->getDetails();

        $this->assertArrayHasKey('name', $constraints);
        $constraintName = $constraints['name'];
        $this->assertEquals('This value is too short. It should have 3 characters or more.', $constraintName->getMessage());
        $this->assertEquals('max', $constraintName->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintName->getInvalidType());
        $this->assertEquals('2', $constraintName->getInvalidValue());

        $this->assertArrayHasKey('surname', $constraints);
        $constraintSurname = $constraints['surname'];
        $this->assertEquals('This value is too short. It should have 4 characters or more.', $constraintSurname->getMessage());
        $this->assertEquals('max', $constraintSurname->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintSurname->getInvalidType());
        $this->assertEquals('3', $constraintSurname->getInvalidValue());

        $this->assertArrayHasKey('personalId', $constraints);
        $constraintPersonalId = $constraints['personalId'];
        $this->assertEquals('This value is too short. It should have 5 characters or more.', $constraintPersonalId->getMessage());
        $this->assertEquals('max', $constraintPersonalId->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintPersonalId->getInvalidType());
        $this->assertEquals('4', $constraintPersonalId->getInvalidValue());
    }

    $this->assertNull($person->getId());    
}

    public function test_createPerson_All_ToLong()
    {
        $person = PersonPattern::getPerson1();
        $person->setName(PersonPattern::Name_ToLong);
        $person->setSurname(PersonPattern::Surname_ToLong);
        $person->setPersonalId(PersonPattern::PersonalId_ToLong);

        $this->assertNull($person->getId());

        try {
            self::$personManager->createPerson($person);
            $this->fail('Exception should be thrown.');
        } catch (ConstraintException $e) {
            $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
            $constraints = $e->getDetails();

            $this->assertArrayHasKey('name', $constraints);
            $constraintName = $constraints['name'];
            $this->assertEquals('This value is too long. It should have 10 characters or less.', $constraintName->getMessage());
            $this->assertEquals('max', $constraintName->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintName->getInvalidType());
            $this->assertEquals('11', $constraintName->getInvalidValue());

            $this->assertArrayHasKey('surname', $constraints);
            $constraintSurname = $constraints['surname'];
            $this->assertEquals('This value is too long. It should have 11 characters or less.', $constraintSurname->getMessage());
            $this->assertEquals('max', $constraintSurname->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintSurname->getInvalidType());
            $this->assertEquals('12', $constraintSurname->getInvalidValue());

            $this->assertArrayHasKey('personalId', $constraints);
            $constraintPersonalId = $constraints['personalId'];
            $this->assertEquals('This value is too long. It should have 15 characters or less.', $constraintPersonalId->getMessage());
            $this->assertEquals('max', $constraintPersonalId->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintPersonalId->getInvalidType());
            $this->assertEquals('16', $constraintPersonalId->getInvalidValue());
        }

        $this->assertNull($person->getId());
    }

    public function test_createPerson_all_have_bad_value() : void {
        $person = new Person('I_mie', 'N_azwisko', '9_0909090dgsgf');
        
        try {
            self::$personManager->createPerson($person);
            $this->fail('Exception should be thrown.');
        } catch (ConstraintException $e) {
            $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
            $constraints = $e->getDetails();
            $this->assertEquals(3, count($constraints));

            $this->assertArrayHasKey('name', $constraints);
            $constraint = $constraints['name'];
            $this->assertEquals('Name can contain only letters.',$constraint->getMessage());
            $this->assertEquals('content', $constraint->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Regex', $constraint->getInvalidType());
            $this->assertEquals('I_mie', $constraint->getInvalidValue());

            $this->assertArrayHasKey('surname', $constraints);
            $constraint = $constraints['surname'];
            $this->assertEquals('Surname can contain only letters.',$constraint->getMessage());
            $this->assertEquals('content', $constraint->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Regex', $constraint->getInvalidType());
            $this->assertEquals('N_azwisko', $constraint->getInvalidValue());

            $this->assertArrayHasKey('personalId', $constraints);
            $constraint = $constraints['personalId'];
            $this->assertEquals('Personal ID can contain only numbers.',$constraint->getMessage());
            $this->assertEquals('content', $constraint->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Regex', $constraint->getInvalidType());
            $this->assertEquals('9_0909090dgsgf', $constraint->getInvalidValue());
        }
    }

    public function test_createPerson_id_not_null()
    {
        self::markTestIncomplete('Person::id rekordu opisującego osobę przed utworzeniem rekordu w bazie powinien być zgłoszony jako błąd.');
    }


}
