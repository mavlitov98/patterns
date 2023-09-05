<?php

declare(strict_types=1);

namespace Creational\Prototype;

/**
 * Паттерн Prototype.
 */

interface ProductInterface
{
}

class PrototypeFactory
{
    private ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function getProduct(): ProductInterface
    {
        return clone $this->product;
    }
}

class SomeProduct implements ProductInterface
{
    public string $name;
}

$prototypeFactory = new PrototypeFactory(new SomeProduct());

$firstProduct = $prototypeFactory->getProduct();
$firstProduct->name = 'The first product';

$secondProduct = $prototypeFactory->getProduct();
$secondProduct->name = 'Second product';

var_dump($firstProduct->name); // The first product
var_dump($secondProduct->name); // Second product
