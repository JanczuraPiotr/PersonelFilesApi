<?php

namespace App\Core\Exception;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Common interface for all constraints: Symfony\Component\Validator\Constraints
 */
class Constraint {

    public function __construct(ConstraintViolation $violation)
    {
        $this->attributeName = $violation->getPropertyPath();
        $this->performAnalysis($violation);
    }
    
    public function getAttributeName() : string {
        return $this->attributeName;
    }
 
    public function getMessage() : string {
        return $this->message;
    }

    public function getViolated() : string {
        return $this->violated;
    }

    public function getInvalidType() : string {
        return $this->invalidType;
    }

    public function getInvalidValue() : string {
        return $this->invalidValue;
    }

    private function performAnalysis(ConstraintViolation $violation) : void {
        $this->message = $violation->getMessage();

        $constraint = $violation->getConstraint();
        if($constraint instanceof Length) {
            if ($violation->getPlural() < $constraint->min) {
                $this->violated = 'min';
            } else {
                $this->violated = 'max';
            }
            $this->invalidType = Length::class;
            $this->invalidValue = strlen($violation->getInvalidValue());
        } else if ($constraint instanceof Regex) {
            $this->violated = "content";
            $this->invalidType = Regex::class;
            $this->invalidValue = $violation->getInvalidValue();
        } else {
            $this->attributeName = "";
            $this->message = "";
            $this->violated = "";
            $this->invalidType = "";
            $this->invalidValue = "";
        }
    }

    private string $attributeName;
    private string $message;
    private string $violated;
    private string $invalidType;
    private string $invalidValue;
}