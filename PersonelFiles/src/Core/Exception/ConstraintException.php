<?php

namespace App\Core\Exception;

use App\Core\Exception\ConstraintViolationException;

class ConstraintException extends ConstraintViolationException {

    public function __construct(string $message, $violations)
    {
        parent::__construct($message, $violations);
    }

    protected function initDetails($violations): ?array
    {
        $report = [];
        foreach ($violations as $violation) {
            $constraint = new Constraint($violation);
            $report[$constraint->getAttributeName()] = $constraint;
        }
        // TODO Jeżeli raport jest pusty to można rzucić wyjątek na temat nie właściwych danych w wyjątku który teraz obsługuję.
        return $report;
    }
}