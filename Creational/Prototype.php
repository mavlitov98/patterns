<?php

declare(strict_types=1);

namespace Creational\Prototype;

/**
 * Паттерн Prototype.
 *
 * В этом примере класс GreetingCard представляет открытку и имеет три свойства: дизайн, содержание и адресата.
 * У класса есть метод clone(), который возвращает клон объекта GreetingCard.
 *
 * Мы создаем исходную открытку-прототип $originalCard, а затем клонируем ее и изменяем содержание для создания новой открытки $newCard.
 * Создание новой открытки происходит без необходимости повторного задания дизайна и адресата, поскольку они наследуются от исходной открытки.
 *
 * Таким образом, использование паттерна Прототип позволяет нам эффективно создавать новые объекты-клоны на основе существующих,
 * сохраняя при этом исходные значения и избегая избыточного дублирования кода.
 */
class GreetingCard
{
    public function __construct(
        public readonly string $design,
        public readonly string $recipient,
        private string $content,
    ) {
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function clone(): GreetingCard
    {
        return new GreetingCard($this->design, $this->recipient, $this->content);
    }
}

// Создаем исходную открытку-прототип
$originalCard = new GreetingCard("Design1", "My Friend", "Happy birthday!");

// Клонируем исходную открытку для создания новой открытки
$newCard = $originalCard->clone();
$newCard->setContent("Congratulations on your promotion!");

// Вывод информации об открытках
echo "Original Card: Design - {$originalCard->design}, Content - {$originalCard->getContent()}, Recipient - {$originalCard->recipient}";
// Original Card: Design - Design1, Content - Happy birthday!, Recipient - My Friend

echo PHP_EOL;

echo "New Card: Design - {$newCard->design}, Content - {$newCard->getContent()}, Recipient - {$newCard->recipient}";
// New Card: Design - Design1, Content - Congratulations on your promotion!, Recipient - My Friend