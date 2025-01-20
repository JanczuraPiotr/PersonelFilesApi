<?php
namespace App\Tests\Person\Service;

use App\Person\Entity\Person;
use App\Person\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Person\Service\PersonService;
use Doctrine\ORM\EntityManagerInterface;

class PersonServiceTest extends KernelTestCase
{
    private static $connection;

    public static function setupBeforeClass(): void
    {
        parent::setupBeforeClass();
        self::bootKernel();

        $container = self::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $personRepository = $container->get(PersonRepository::class);
        self::$connection = $entityManager->getConnection();
    }
    
    public function setUp(): void
    {
        parent::setUp();
        self::$connection->executeQuery('DELETE FROM person');
    }        

    protected function tearDown(): void
    {
    }

    public function test_DeleteById_InputIsNull(): void
    {
        
        self::markTestIncomplete("Usunięcie osoby z bazy na podstawie klucza głównego. Brak klucza głównego w zapytaniu.");
    }
    
    public function test_DeleteById_IdExists() : void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie istniejącego klucza głównego.");
    }

    public function test_DeleteById_IdNotExists(): void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie nie istniejącego klucza głównego.");
    }

    public function test_FindAll_EmptyList(): void
    {
        self::markTestIncomplete("Pobranie listy wszystkich osób. Lista jest pusta.");
    }

    public function test_findById_InputIsNull(): void
    {
        self::markTestIncomplete("Szukanie osoby na podstawie klucza głównego. Brak klucza głównego w zapytaniu.");
    }

    public function test_findById_IdExists(): void 
    {
        self::markTestIncomplete("Szukanie osoby na podstawie istniejącego klucza głównego.");
    }

    public function test_findById_IdNotExists(): void 
    {
        self::markTestIncomplete("Szukanie osoby na podstawie nie istniejącego klucza głównego.");
    }

    public function test_findByName_InputIsNull(): void 
    {
        self::markTestIncomplete("Szukanie osoby na podstawie imienia. Brak imienia w zapytaniu.");
    }

    public function test_findByName_NameExists(): void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie istniejącego imienia.");
    }

    public function test_findByName_NameNotExists(): void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie nie istniejącego imienia.");
    }

    public function test_findBySurname_InputIsNull(): void 
    {
        self::markTestIncomplete("Szukanie osoby na podstawie nazwiska. Brak nazwiska w zapytaniu.");
    }

    public function test_findBySurname_SurnameExists(): void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie istniejącego nazwiska.");
    }

    public function test_findBySurname_SurnameNotExists(): void 
    {
        self::markTestIncomplete("Usuwanie osoby na podstawie nie istniejącego nazwiska.");
    }

    public function test_createPerson(): void 
    {
//        $person = new Person();
//        $person->setId(null);
//        $person->setName("Jan");
//        $person->setSurname("Kowalski");
//        $person->setPersonalId("12345");
//
//        $this->personService->createPerson($person);
//        $newPerson = $this->personRepository->findById(1);
//
//        $this->assertNotNull($newPerson);
//        $this->assertNotNull($newPerson->getId());
        self::markTestIncomplete("Zapisanie osoby do bazy.");
    }

    public function test_Save_InputIsNull(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Brak danych osoby w zapytaniu.");
    }

    public function test_Save_PersonalIdDuplicate(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Osoba o podanym identyfikatorze istnieje już w bazie.");
    }

    public function test_Save_PersonalIdToShort(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. PersonalId dodawanej osoby jest za krótki.");
    }

    public function test_Save_PersonalIdToLong(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. PersonalId dodawanej osoby jest za długi.");
    }

    public function test_Save_NameToShort(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Imię dodawanej osoby jest za krótkie.");
    }

    public function test_Save_NameToLong(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Imię dodawanej osoby jest za długie.");
    }

    public function test_Save_SurnameToShort(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Nazwisko dodawanej osoby jest za krótkie.");
    }

    public function test_Save_SurnameToLong(): void 
    {
        self::markTestIncomplete("Zapisanie osoby do bazy. Nazwisko dodawanej osoby jest za długie.");
    }

    public function test_Update(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie.");
    }

    public function test_Update_PersonalIdDuplicate(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. Osoba o podanym identyfikatorze istnieje już w bazie.");
    }

    public function test_Update_PersonalIdToShort(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. PersonalId dodawanej osoby jest za krótki.");
    }

    public function test_Update_PersonalIdToLong(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. PersonalId dodawanej osoby jest za długi.");
    }

    public function test_Update_NameToShort(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. Imię dodawanej osoby jest za krótkie.");
    }

    public function test_Update_NameToLong(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. Imię dodawanej osoby jest za długie.");
    }

    public function test_Update_SurnameToShort(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. Nazwisko dodawanej osoby jest za krótkie.");
    }

    public function test_Update_SurnameToLong(): void 
    {
        self::markTestIncomplete("Aktualizacja danych osoby w bazie. Nazwisko dodawanej osoby jest za długie.");
    }
}