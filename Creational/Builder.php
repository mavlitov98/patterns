<?php

declare(strict_types=1);

namespace Creational\Builder;

/**
 * Паттерн Builder.
 */

class Product
{
    private string $name;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class Factory
{
    private Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
        $this->builder->buildProduct();
    }

    public function getProduct(): Product
    {
        return $this->builder->getProduct();
    }
}

abstract class Builder
{
    protected Product $product;

    final public function getProduct(): Product
    {
        return $this->product;
    }

    public function buildProduct(): void
    {
        $this->product = new Product();
    }
}

class FirstBuilder extends Builder
{
    public function buildProduct(): void
    {
        parent::buildProduct();
        $this->product->setName('Результат из FirstBuilder');
    }
}

class SecondBuilder extends Builder
{
    public function buildProduct(): void
    {
        parent::buildProduct();
        $this->product->setName('Результат из SecondBuilder');
    }
}

$first = new Factory(new FirstBuilder());
$second = new Factory(new SecondBuilder());

var_dump($first->getProduct()->getName()); // Результат из FirstBuilder
var_dump($second->getProduct()->getName()); // Результат из SecondBuilder
