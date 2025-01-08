<?php
namespace App\Tests\Person;

use PHPUnit\Framework\TestCase;

class PersonControllerTest extends TestCase
{   
    public function test_CreatePerson(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca dane osoby z nadanym id i poprawny status');
    }

    public function test_CreatePerson_PersonalIdDuplicated(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o duplikacji personalId');
    }

    public function test_CreatePerson_PersonalIdToShort(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za krótkim personalId');
    }

    public function test_CreatePerson_PersonalIdToLong(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za długim personalId');
    }

    public function test_CreatePerson_NameToShort(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za krótkim imieniu');
    }

    public function test_CreatePerson_NameToLong(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za długim imieniu');
    }

    public function test_CreatePerson_SurnameToShort(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za krótkim nazwisku');
    }

    public function test_CreatePerson_SurnameToLong(): void
    {
        self::markTestIncomplete('Dodanie osoby do bazy -> sprawdzenie czy zwraca błąd o za długim nazwisku');
    }

    public function test_DeletePerson_PersonExists(): void 
    {
        self::markTestIncomplete('Usunięcie osoby z bazy -> sprawdzenie czy zwraca poprawny status');
    }

    public function test_DeletePerson_PeresonNotExists() : void 
    {
        self::markTestIncomplete('Usunięcie osoby z bazy -> sprawdzenie czy zwraca błąd o braku osoby');
    }

    public function test_findAllPersons(): void 
    {
        self::markTestIncomplete('Pobranie wszystkich osób z bazy -> sprawdzenie czy zwraca poprawną ilość osób');
    }

    public function test_findPersonById_IdExists() : void 
    {
        self::markTestIncomplete('Pobranie osoby po id -> sprawdzenie czy zwraca poprawne dane osoby');
    }

    public function test_UpdatePersonIfExists(): void 
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca poprawny status');
    }

    public function test_UpdatePersonIfNotExists(): void 
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o braku osoby');
    }

    public function test_UpdatePerson_PersonalIdDuplicated(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o duplikacji personalId');
    }

    public function test_UpdatePerson_PersonalIdToShort(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za krótkim personalId');
    }

    public function test_UpdatePerson_PersonalIdToLong(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za długim personalId');
    }

    public function test_UpdatePerson_NameToShort(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za krótkim imieniu');
    }

    public function test_UpdatePerson_NameToLong(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za długim imieniu');
    }

    public function test_UpdatePerson_SurnameToShort(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za krótkim nazwisku');
    }

    public function test_UpdatePerson_SurnameToLong(): void
    {
        self::markTestIncomplete('Aktualizacja danych osoby -> sprawdzenie czy zwraca błąd o za długim nazwisku');
    }
}
