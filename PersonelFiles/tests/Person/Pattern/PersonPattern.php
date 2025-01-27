<?php

namespace App\Tests\Person\Pattern;

use App\Person\Entity\Person;

class PersonPattern
{

    public function getPersonToShort(): Person {
        if ($this->personToShort === null) {
            $this->personToShort = new Person($this->randomString(Person::NAME_LENGTH_MIN - 1),
                                              $this->randomString(Person::SURNAME_LENGTH_MIN - 1),
                                              $this->randomCharNumberMix(Person::PERSONAL_ID_LENGTH_MIN - 1));
        }
        return $this->personToShort;
    }

    public function getPersonCorrectMin(): Person {
        if ($this->personCorrectMin === null) {
            $this->personCorrectMin = new Person($this->randomString(Person::NAME_LENGTH_MIN),
                                                 $this->randomString(Person::SURNAME_LENGTH_MIN),
                                                 $this->randomCharNumberMix(Person::PERSONAL_ID_LENGTH_MIN));
        }
        return $this->personCorrectMin;
    }
    
    public function getPersonCorrect(): Person {
        if ($this->personCorrect === null) {
            $this->personCorrect = new Person($this->randomString(Person::NAME_LENGTH_MAX),
                                              $this->randomString(Person::SURNAME_LENGTH_MAX),
                                              $this->randomCharNumberMix(Person::PERSONAL_ID_LENGTH_MAX));
        }
        return $this->personCorrect;
    }
    
    public function getPersonCorrectMax(): Person {
        if ($this->personCorrectMax === null) {
            $this->personCorrectMax = new Person($this->randomString(Person::NAME_LENGTH_MAX),
                                                 $this->randomString(Person::SURNAME_LENGTH_MAX),
                                                 $this->randomCharNumberMix(Person::PERSONAL_ID_LENGTH_MAX));
        }
        return $this->personCorrectMax;
    }

    public function getPersonToLong(): Person {
        if ($this->personToLong === null) {
            $this->personToLong = new Person($this->randomString(Person::NAME_LENGTH_MAX + 1),
                                             $this->randomString(Person::SURNAME_LENGTH_MAX + 1),
                                             $this->randomCharNumberMix(Person::PERSONAL_ID_LENGTH_MAX + 1));
        }
        return $this->personToLong;
    }

    public function parseConditionals(): void {


        // TODO Uruchomić pobieranie ograniczeń z adnotacji.
//         $reader = new AnnotationReader();
//
//         // Odczytaj adnotacje z klasy
//         $classAnnotations = $reader->getClassAnnotations(new \ReflectionClass(Person::class));
//         foreach ($classAnnotations as $annotation) {
//             var_dump($annotation);
//         }
//
//         // Odczytaj adnotacje z właściwości
//         $propertyAnnotations = $reader->getPropertyAnnotations(new \ReflectionProperty(Person::class, 'name')); // Zastąp 'Name_ToShort' nazwą właściwości
//         foreach ($propertyAnnotations as $annotation) {
//             var_dump($annotation);
//         }

    }

    private function randomString(int $length) : string {
        $chars = range('A', 'Z');
        $ret = '';

        for ($i = 0; $i < $length; $i++) {
            $ret .= $chars[array_rand($chars)];
        }

        return $ret;
    }

    private function randomCharNumberMix(int $length) : string {
        $chars = array_merge(range('A', 'Z'), range('0', '9'));
        $ret = '';

        for ($i = 0; $i < $length; $i++) {
            $ret .= $chars[array_rand($chars)];
        }

        return $ret;
    }

    private ?Person $personToShort = null;
    private ?Person $personCorrectMin = null;
    private ?Person $personCorrect = null;
    private ?Person $personCorrectMax = null;
    private ?Person $personToLong = null;

}