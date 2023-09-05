<?php

declare(strict_types=1);

namespace Creational\Singleton;

/**
 * Паттерн Singleton.
 *
 * При первом обращении класс сам создаст экземпляр себя в свойство Singleton::$instance.
 * При последующих обращениях, в рамках выполнения скрипта, метод будет возвращать тот же экземпляр класса.
 *
 * Было добавлено публичное свойство $data, чтобы продемонстрировать работу паттерна.
 * В данном примере можно увидеть, что и $first, и $second ссылаются на один и тот же объект.
 */

class Singleton
{
    private static ?Singleton $instance = null;
    public ?string $data = null;

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    private function __construct() {}
    private function __clone() {}
}

$first = Singleton::getInstance();
$second = Singleton::getInstance();

$first->data = 'first';
$second->data = 'second';

var_dump($first->data); // second
var_dump($first->data); // second
