<?php

namespace App\Tests\Person\Pattern;

use App\Person\Entity\Person;

class PersonPattern
{
    public const Name_ToShort               = 'Ab';
    public const Name_Correct_LongMin       = 'Abc';
    public const Name_Correct_LongMax       = 'Abcdefghij';
    public const Name_ToLong                = 'Abcdefghijk';

    public const Surname_ToShort            = "Lmn";
    public const Surname_Correct_LongMin    = "Lmno";
    public const Surname_Correct_LongMax    = "Lmnoprstquw";
    public const Surname_ToLong             = "Lmnoprstquwy";

    public const PersonalId_ToShort         = "1234";
    public const PersonalId_Correct_LongMin = "A2345";
    public const PersonalId_Correct_LongMax = "1234567890abcde";
    public const PersonalId_ToLong          = "1234567890abcdef";

    public static function getPerson1(): Person {
        return new Person(self::Name_Correct_LongMin,
                          self::Surname_Correct_LongMin, 
                          self::PersonalId_Correct_LongMin);
    }                                      
    
    public static function getPerson2(): Person {
        return new Person(self::Name_Correct_LongMin.'x',
                          self::Surname_Correct_LongMin.'y', 
                          self::PersonalId_Correct_LongMin.'z');
    }                                      
    
    public static function getPerson3(): Person {
        return new Person(self::Name_Correct_LongMax,
                          self::Surname_Correct_LongMax, 
                          self::PersonalId_Correct_LongMax);
    }                                      

    protected static function nameToShort(): string {
        return 'Abc';
    }
}