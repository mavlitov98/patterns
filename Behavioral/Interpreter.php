<?php

declare(strict_types=1);

namespace Behavioral\Interpreter;

/**
 * Паттерн Interpreter.
 *
 * Он позволяет нам интерпретировать текстовые команды и выполнять соответствующие действия в зависимости от содержания команды.
 * Это полезно в случаях, когда требуется обрабатывать сложные команды или управлять поведением системы на основе текстовых вводов.
 */
interface Expression
{
    public function interpret(string $context): bool;
}

class OrderExpression implements Expression
{
    public function __construct(
        private readonly array $keywords
    ) {
    }

    public function interpret(string $context): bool
    {
        foreach ($this->keywords as $keyword) {
            if (str_contains($context, $keyword)) {
                return true;
            }
        }

        return false;
    }
}

class Chef
{
    public function handleOrder(string $order): void
    {
        $expressions = [
            new OrderExpression(['pizza', 'пицца']),
            new OrderExpression(['pasta', 'паста'])
        ];

        foreach ($expressions as $expression) {
            if ($expression->interpret($order)) {
                $this->prepareFood($order);
                return;
            }
        }

        echo 'Извините, но мы не можем выполнить ваш заказ.';
    }

    private function prepareFood(string $order): void
    {
        echo "Готовим заказ: {$order}";
    }
}

// Клиентский код
$chef = new Chef();
$chef->handleOrder('У вас есть пицца?');


