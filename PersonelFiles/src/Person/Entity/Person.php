<?php

namespace App\Person\Entity;

use App\Person\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraint;

// TODO Usunąć set...() i tworzyć obiekt poprzez parametry konstruktora

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\Table(name: "person")]
#[ORM\UniqueConstraint(name: "unique_personal_number", columns: ["personal_id"])]
class Person
{
    public const NAME_LENGTH_MIN            = 3;
    public const NAME_LENGTH_MAX            = 10;
    public const SURNAME_LENGTH_MIN         = 4;
    public const SURNAME_LENGTH_MAX         = 11;
    public const PERSONAL_ID_LENGTH_MIN     = 5;
    public const PERSONAL_ID_LENGTH_MAX     = 15;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: self::NAME_LENGTH_MAX)]
    #[Constraint\Length(min: self::NAME_LENGTH_MIN, max: self::NAME_LENGTH_MAX)]
    #[Constraint\Regex(pattern: "/^[A-Za-z]+$/", message: "Name can contain only letters.")]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: self::SURNAME_LENGTH_MAX)]
    #[Constraint\Length(min: self::SURNAME_LENGTH_MIN, max: self::SURNAME_LENGTH_MAX)]
    #[Constraint\Regex(pattern: "/^[A-Za-z]+$/", message: "Surname can contain only letters.")]
    private ?string $surname = null;

    #[ORM\Column(type: "string", length: self::PERSONAL_ID_LENGTH_MAX, unique: true, nullable: false)]
    #[Constraint\Length(min: self::PERSONAL_ID_LENGTH_MIN, max: self::PERSONAL_ID_LENGTH_MAX)]
    #[Constraint\Regex(pattern: "/^[0-9A-Za-z]+$/", message: "Personal ID can contain only numbers.")]
    private ?string $personalId = null;
    
    public function __construct(?string $name, ?string $surname, ?string $personalId)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->personalId = $personalId;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPersonalId(): ?string
    {
        return $this->personalId;
    }

    public function setPersonalId(string $personalId): self
    {
        $this->personalId = $personalId;

        return $this;
    }
}
