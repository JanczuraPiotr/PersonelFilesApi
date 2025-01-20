<?php
namespace App\Tests\Person\Repository;

use App\Core\Exception\ConstraintException;
use App\Person\Entity\Person;
use App\Tests\Person\Pattern\PersonPattern;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonRepositoryTest extends KernelTestCase
{
    const NOT_EXISTING_PERSON_ID = 123;

    // private static $entityManager;
    private static $connection;
    private static $personRepository;

     public static function setUpBeforeClass(): void
     {
         parent::setUpBeforeClass();

         $kernel = self::bootKernel();
         $entityManager = $kernel->getContainer()->get('doctrine')->getManager();
         self::$personRepository = $entityManager->getRepository(Person::class);
         self::$connection = $entityManager->getConnection();

         // self::$connection->executeQuery('truncate table person');
         self::$connection->executeQuery('DELETE FROM person');
     }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::$connection->executeQuery('DELETE FROM person');
    }

    public function testNotFountPerson()
    {

        $person = self::$personRepository->findById(self::NOT_EXISTING_PERSON_ID);
        $this->assertNull($person);
    }

    public function test_CreatePerson_Correct()
    {
        $person = PersonPattern::getPerson1();
        $this->assertNull($person->getId());

        self::$personRepository->save($person);
     
        $this->assertNotNull($person->getId());
    }

   public function test_CreatePerson_All_ToShort()
   {
    $person = PersonPattern::getPerson1();
    $person->setName(PersonPattern::Name_ToShort);
    $person->setSurname(PersonPattern::Surname_ToShort);
    $person->setPersonalId(PersonPattern::PersonalId_ToShort);

    $this->assertNull($person->getId());

    try {
        self::$personRepository->save($person);
        $this->fail('Exception should be thrown.');
    } catch (ConstraintException $e) {
        $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
        $constraints = $e->getDetails();

        $this->assertNotEmpty($constraints['name']);
        $constraintName = $constraints['name'];
        $this->assertEquals('This value is too short. It should have 3 characters or more.', $constraintName->getMessage());
        $this->assertEquals('max', $constraintName->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintName->getInvalidType());
        $this->assertEquals('2', $constraintName->getInvalidValue());

        $this->assertNotEmpty($constraints['surname']);
        $constraintSurname = $constraints['surname'];
        $this->assertEquals('This value is too short. It should have 4 characters or more.', $constraintSurname->getMessage());
        $this->assertEquals('max', $constraintSurname->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintSurname->getInvalidType());
        $this->assertEquals('3', $constraintSurname->getInvalidValue());

        $this->assertNotEmpty($constraints['personalId']);
        $constraintPersonalId = $constraints['personalId'];
        $this->assertEquals('This value is too short. It should have 5 characters or more.', $constraintPersonalId->getMessage());
        $this->assertEquals('max', $constraintPersonalId->getViolated());
        $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintPersonalId->getInvalidType());
        $this->assertEquals('4', $constraintPersonalId->getInvalidValue());
    }

    $this->assertNull($person->getId());    }

    public function test_createPerson_All_ToLong()
    {
        $person = PersonPattern::getPerson1();
        $person->setName(PersonPattern::Name_ToLong);
        $person->setSurname(PersonPattern::Surname_ToLong);
        $person->setPersonalId(PersonPattern::PersonalId_ToLong);

        $this->assertNull($person->getId());

        try {
            self::$personRepository->save($person);
            $this->fail('Exception should be thrown.');
        } catch (ConstraintException $e) {
            $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
            $constraints = $e->getDetails();

            $this->assertNotEmpty($constraints['name']);
            $constraintName = $constraints['name'];
            $this->assertEquals('This value is too long. It should have 10 characters or less.', $constraintName->getMessage());
            $this->assertEquals('max', $constraintName->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintName->getInvalidType());
            $this->assertEquals('11', $constraintName->getInvalidValue());

            $this->assertNotEmpty($constraints['surname']);
            $constraintSurname = $constraints['surname'];
            $this->assertEquals('This value is too long. It should have 11 characters or less.', $constraintSurname->getMessage());
            $this->assertEquals('max', $constraintSurname->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintSurname->getInvalidType());
            $this->assertEquals('12', $constraintSurname->getInvalidValue());

            $this->assertNotEmpty($constraints['personalId']);
            $constraintPersonalId = $constraints['personalId'];
            $this->assertEquals('This value is too long. It should have 15 characters or less.', $constraintPersonalId->getMessage());
            $this->assertEquals('max', $constraintPersonalId->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Length', $constraintPersonalId->getInvalidType());
            $this->assertEquals('16', $constraintPersonalId->getInvalidValue());
        }

        $this->assertNull($person->getId());
    }

    public function test_createPerson_PersonalId_has_bad_value() : void {
        $person = PersonPattern::getPerson1();
        $person->setPersonalId('123456$%90909090dgsgf');

        try {
            self::$personRepository->save($person);
            $this->fail('Exception should be thrown.');
        } catch (ConstraintException $e) {
            $this->assertEquals('Constraint violations in class: '.Person::class, $e->getMessage());
            $constraints = $e->getDetails();
            $this->assertEquals(1, count($constraints));
            $this->assertNotEmpty($constraints['personalId']);
            $constraint = $constraints['personalId'];
            $this->assertEquals('Personal ID can contain only numbers.',$constraint->getMessage());
            $this->assertEquals('content', $constraint->getViolated());
            $this->assertEquals('Symfony\Component\Validator\Constraints\Regex', $constraint->getInvalidType());
            $this->assertEquals('123456$%90909090dgsgf', $constraint->getInvalidValue());
        }
    }

    public function test_createPerson_id_not_null()
    {
        self::markTestIncomplete('Person::id rekordu opisującego osobę przed utworzeniem rekordu w bazie powinien być zgłoszony jako błąd.');
    }


}
