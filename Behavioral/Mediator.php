<?php

declare(strict_types=1);

namespace Behavioral\Mediator;

/**
 * Паттерн Mediator.
 *
 * В этом примере паттерн Посредник (Mediator) позволяет нам управлять взаимодействием между разработчиками в команде без прямого обращения друг к другу.
 *
 * Интерфейс ChatMediator определяет метод sendMessage(), который используется для отправки сообщений между разработчиками.
 *
 * Класс TeamChat реализует интерфейс ChatMediator и содержит массив $developers, в котором хранятся все разработчики.
 * У него есть методы addDeveloper(), который добавляет разработчиков в список, и sendMessage(),
 * который отправляет сообщение всем разработчикам, кроме отправителя.
 *
 * Абстрактный класс Developer является базовым классом для всех разработчиков и содержит ссылку на посредника (чат) $mediator.
 * Он имеет абстрактный метод sendMessage(), который переопределяется в конкретных классах разработчиков для отправки сообщений.
 * Есть также метод receiveMessage(), который выводит полученное сообщение на экран.
 *
 * Классы BackendDeveloper и FrontendDeveloper представляют конкретных разработчиков и наследуются от Developer.
 * Они реализуют абстрактный метод sendMessage() и передают сообщение посреднику (чату) $mediator.
 *
 * Далее мы создаем объект TeamChat, представляющий посредника (чат), и объекты BackendDeveloper и FrontendDeveloper.
 * Мы добавляем этих разработчиков в чат и они могут отправлять сообщения через посредника.
 *
 * В итоге, при запуске скрипта, мы видим, что каждый разработчик отправляет свое сообщение через посредника,
 * и оно доставляется остальным разработчикам, которые получают его и выводят на экран.
 *
 * Паттерн Посредник позволяет нам решать проблемы связанные со связью и взаимодействием между объектами,
 * обеспечивает слабую связанность (loose coupling) между компонентами системы и упрощает их масштабируемость и поддержку.
 */
interface ChatMediator
{
    public function sendMessage(string $message, Developer $sender): void;
}

class TeamChat implements ChatMediator
{
    /** @var list<Developer> */
    private array $developers = [];

    public function addDeveloper(Developer $developer): void
    {
        $this->developers[] = $developer;
    }

    public function sendMessage(string $message, Developer $sender): void
    {
        foreach ($this->developers as $developer) {
            if ($developer !== $sender) {
                $developer->receiveMessage($message);
            }
        }
    }
}

abstract class Developer
{
    protected ChatMediator $mediator;

    public function __construct(ChatMediator $mediator)
    {
        $this->mediator = $mediator;
    }

    abstract public function sendMessage(string $message): void;

    public function receiveMessage(string $message): void
    {
        echo get_class($this) . " received message: {$message}\n";
    }
}

class BackendDeveloper extends Developer
{
    public function sendMessage(string $message): void
    {
        echo "Backend developer sends message: {$message}\n";
        $this->mediator->sendMessage($message, $this);
    }
}

class FrontendDeveloper extends Developer
{
    public function sendMessage(string $message): void
    {
        echo "Frontend developer sends message: {$message}\n";
        $this->mediator->sendMessage($message, $this);
    }
}

// Создаем посредника (чат)
$chat = new TeamChat();

// Создаем разработчиков
$backendDeveloper = new BackendDeveloper($chat);
$frontendDeveloper = new FrontendDeveloper($chat);

// Добавляем разработчиков в чат
$chat->addDeveloper($backendDeveloper);
$chat->addDeveloper($frontendDeveloper);

// Разработчики могут общаться через посредника (чат)
$backendDeveloper->sendMessage('Hello from backend!');
$frontendDeveloper->sendMessage("Hi! I'm frontend!");
