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
    private static $personPattern;
    private static $entityManager;

     public static function setUpBeforeClass(): void
     {
        parent::setUpBeforeClass();
        $kernel = self::bootKernel();
        $it = new self();
        self::$personPattern = $kernel->getContainer()->get(PersonPattern::class);


        $personRepository = $it->createMock(PersonRepository::class);
        self::$entityManager = $it->createMock(EntityManager::class);

        $validator = $kernel->getContainer()
            ->get('test.service_container')
            ->get('validator');

        self::$personManager = new PersonManager($personRepository, self::$entityManager, $validator);
    }

    public function testNotFountPerson()
    {
        $person = self::$personManager->findOneById(self::NOT_EXISTING_PERSON_ID);
        $this->assertNull($person);
    }

    public function test_CreatePerson_Correct()
    {
        $person = self::$personPattern->getPersonCorrectMin();
        $this->assertNull($person->getId());

        self::$entityManager->method('persist')
                            ->will($this->returnCallback(function($entity) {
                                $entity->setId(1);
                            }));

        self::$personManager->createPerson($person);

        $this->assertEquals(1, $person->getId());
    }

   public function test_CreatePerson_All_ToShort()
   {
    $person = self::$personPattern->getPersonToShort();

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
        $person = self::$personPattern->getPersonToLong();

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
        $person = self::$personPattern->getPersonCorrectMin();
        $person->setId(1);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Person::id before creating record have to be null.');

        self::$personManager->createPerson($person);

    }


}
