<?php

namespace App\Tests;

use App\Tests\Person\Pattern\PersonPattern;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineBehaviorTest extends KernelTestCase {

    private static $entityManager;
    private static $connection;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        $kernel = self::bootKernel();   

        self::$entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        self::$connection = self::$entityManager->getConnection();
        self::$connection->executeQuery('TRUNCATE person');
        // self::$connection->executeQuery('DELETE FROM person');
    }

    protected function tearDown(): void {
        parent::tearDown();
        self::$connection->executeQuery('DELETE FROM person');
    }

    public function test_createPerson_correct() {
        $person = PersonPattern::getPerson1();
        $this->assertNull($person->getId());
        self::$entityManager->persist($person);
        self::$entityManager->flush();
        $this->assertNotNull($person->getId());                
    }

    public function test_createPerson_all_toShort() {
        $person = PersonPattern::getPersonToShort();

        $this->assertNull($person->getId());

        self::$entityManager->persist($person);
        self::$entityManager->flush();

        $this->assertNotNull($person->getId());

    }

    public function test_createPerson_all_toLong() {
        $person = PersonPattern::getPersonToLong();

        $this->assertNull($person->getId());
        
        $this->expectException(\Doctrine\DBAL\Exception\DriverException::class);
        self::$entityManager->persist($person);
        self::$entityManager->flush();

        $this->assertNotNull($person->getId());
    }
}


