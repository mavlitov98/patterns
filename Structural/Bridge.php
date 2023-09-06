<?php

declare(strict_types=1);

namespace Structural\Bridge;

/**
 * Паттерн Bridge.
 *
 * В данном примере у нас есть иерархия классов для отправки сообщений:
 * MessageSenderInterface представляет интерфейс для реализации различных способов отправки сообщений, например, через SMS или по электронной почте.
 *
 * Затем у нас есть абстрактный класс AbstractMessageSender, представляющий абстракцию для отправки сообщений.
 * У этого класса есть поле "sender" типа MessageSenderInterface, которое представляет конкретный способ отправки сообщений.
 *
 * Далее у нас есть две конкретные реализации абстракции: NormalMessage и UrgentMessage.
 * Оба класса наследуются от AbstractMessageSender и переопределяют метод send(),
 * добавляя специфическую логику для форматирования сообщения перед его отправкой.
 *
 * В конечном итоге, мы создаем объекты NormalMessage и UrgentMessage, передавая им конкретные реализации отправителей SmsSender и EmailSender.
 * Затем мы вызываем метод send(), который вызывает соответствующий метод отправки сообщения у выбранного отправителя.
 *
 * Паттерн "Bridge" позволяет независимо изменять иерархию сообщений (NormalMessage, UrgentMessage) и
 * способ их отправки (SmsSender, EmailSender), не связываясь их прочной связью.
 */
// Интерфейс для реализации различных вариантов отправки сообщений
interface MessageSenderInterface
{
    public function send(string $message): string;
}

// Реализация отправки сообщений через SMS
class SmsSender implements MessageSenderInterface
{
    public function send(string $message): string
    {
        return "SMS: {$message}";
    }
}

// Реализация отправки сообщений через Email
class EmailSender implements MessageSenderInterface
{
    public function send(string $message): string
    {
        return "Email: {$message}";
    }
}

// Абстракция для отправки сообщений
abstract class AbstractMessageSender
{
    public function __construct(
        protected MessageSenderInterface $sender,
    ) {
    }

    abstract public function send(string $message): string;
}

// Конкретная реализация абстракции для обычного сообщения
class NormalMessageSender extends AbstractMessageSender
{
    public function send(string $message): string
    {
        return $this->sender->send("[Normal] {$message}");
    }
}

// Конкретная реализация абстракции для важного сообщения
class UrgentMessageSender extends AbstractMessageSender
{
    public function send(string $message): string
    {
        return $this->sender->send("[Urgent] {$message}");
    }
}

$normalSmsSender = new NormalMessageSender(new SmsSender());
var_dump($normalSmsSender->send('Hello, World!')); // Ожидаемый результат: "SMS: [Normal] Hello, World!"

$urgentEmailSender = new UrgentMessageSender(new EmailSender());
var_dump($urgentEmailSender->send('Important message!')); // Ожидаемый результат: "Email: [Urgent] Important message!"

