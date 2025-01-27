<?php

namespace App\Tests;

use App\Tests\Person\Pattern\PersonPattern;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineBehaviorTest extends KernelTestCase {

    private static $entityManager;
    private static $connection;
    private static $personPattern;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        $kernel = self::bootKernel();   

        self::$personPattern = $kernel->getContainer()->get(PersonPattern::class);
        self::$entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        self::$connection = self::$entityManager->getConnection();

        self::$connection->executeQuery('TRUNCATE person');
        // self::$connection->executeQuery('DELETE FROM person');

        self::$personPattern->parseConditionals();
    }

    protected function tearDown(): void {
        parent::tearDown();
        self::$connection->executeQuery('DELETE FROM person');
    }

    public function test_createPerson_correct() {

        $person = self::$personPattern->getPersonCorrectMin();
        $this->assertNull($person->getId());
        self::$entityManager->persist($person);
        self::$entityManager->flush();
        $this->assertNotNull($person->getId());                
    }

    public function test_createPerson_all_toShort() {
        $person = self::$personPattern->getPersonToShort();

        $this->assertNull($person->getId());

        self::$entityManager->persist($person);
        self::$entityManager->flush();

        $this->assertNotNull($person->getId());

    }

    public function test_createPerson_all_toLong() {
        $person = self::$personPattern->getPersonToLong();

        $this->assertNull($person->getId());
        
        $this->expectException(DriverException::class);
        self::$entityManager->persist($person);
        self::$entityManager->flush();

    }
}


