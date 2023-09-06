<?php

declare(strict_types=1);

namespace Creational\Builder;

/**
 * Паттерн Builder.
 *
 * В этом примере класс User представляет пользователя с набором свойств: имя, возраст, электронная почта и адрес.
 * Класс UserBuilder предоставляет методы для установки каждого свойства пользователя с возможностью цепного вызова.
 * Метод build() возвращает готовый объект User.
 */

class User
{
    public function __construct(
        private readonly string $name,
        private readonly int $age,
        private readonly string $email,
        private readonly string $address
    ) {
    }

    public function getInfo(): string
    {
        return "Name: {$this->name}, Age: {$this->age}, Email: {$this->email}, Address: {$this->address}";
    }
}

class UserBuilder
{
    private string $name;
    private int $age;
    private string $email;
    private string $address;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function build(): User
    {
        return new User($this->name, $this->age, $this->email, $this->address);
    }
}

// Использование паттерна Builder
$user = (new UserBuilder())
    ->setName("Builder Petrovich")
    ->setAge(25)
    ->setEmail("builder@example.com")
    ->setAddress("123 Street, City")
    ->build();

var_dump($user->getInfo());
