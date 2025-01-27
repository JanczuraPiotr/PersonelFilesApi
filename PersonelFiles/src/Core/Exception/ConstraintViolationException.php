<?php

namespace App\Core\Exception;

/**
 * The basis for exceptions thrown when attempting to set class attributes to an invalid value.
 */
abstract class ConstraintViolationException extends Exception
{
    /**
     * @param string $class The class was not created because the attributes used to construct it had invalid values. 
     * @param array $violations An array of classes of the appropriate type for violations.
     */
    public function __construct(string $class, $metaInfoAboutViolations) {
        parent::__construct('Constraint violations in class: '.$class);
        $this->details = $this->initDetails($metaInfoAboutViolations);
        $this->class = $class;
    }

    /**
     * The class was not created because the attributes used to construct it had invalid values. 
     *
     * @return string
     */
    public function getClass(): string  {
        return $this->class;
    }

    /**
     * @return array An array of classes of the appropriate type for violations.
     */
    public function getDetails(): array {
        return $this->details;
    }

    /**
     * Build a list of classes with the interface required in the upper layer.
     * 
     * @param [type] $violations Meta information about violations. 
     *         Based on them, build a list of classes with the interface required in the upper layer.
     * @return array|null
     */
    protected abstract function initDetails($violations): ?array;


    private string $class;
    private array $details;

}