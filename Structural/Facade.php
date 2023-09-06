<?php

declare(strict_types=1);

namespace Structural\Facade;

/**
 * Паттерн Facade.
 *
 * В этой реализации у нас есть различные подсистемы (OrderProcessor, InvoiceGenerator, NotificationSender),
 * каждая из которых выполняет определенные задачи в процессе размещения заказа.
 *
 * OrderFacade создает упрощенный интерфейс, который объединяет вызовы подсистем и предоставляет один метод placeOrder(),
 * который делегирует работу соответствующим подсистемам.
 *
 * Паттерн "Facade" позволяет предоставить простой интерфейс к сложной системе подсистем.
 * Фасад скрывает сложность и детали взаимодействия между подсистемами, предоставляя упрощенный интерфейс для взаимодействия с ними.
 * Это особенно полезно, когда нужно предоставить удобный способ использования сложной функциональности.
 */

// Подсистема для обработки заказа
class OrderProcessor
{
    public function processOrder(): void
    {
        echo "Заказ обрабатывается...\n";
    }
}

// Подсистема для генерации счета
class InvoiceGenerator
{
    public function generateInvoice(): void
    {
        echo "Генерация счета...\n";
    }
}

// Подсистема для отправки уведомления
class NotificationSender
{
    public function sendNotification(): void
    {
        echo "Отправка уведомления...\n";
    }
}

// Фасад, который предоставляет упрощенный интерфейс для заказа
class OrderFacade
{
    protected OrderProcessor $orderProcessor;
    protected InvoiceGenerator $invoiceGenerator;
    protected NotificationSender $notificationSender;

    public function __construct()
    {
        $this->orderProcessor = new OrderProcessor();
        $this->invoiceGenerator = new InvoiceGenerator();
        $this->notificationSender = new NotificationSender();
    }

    public function placeOrder(): void
    {
        $this->orderProcessor->processOrder();
        $this->invoiceGenerator->generateInvoice();
        $this->notificationSender->sendNotification();
    }
}

// Использование фасада для размещения заказа
$orderFacade = new OrderFacade();

// Заказ обрабатывается...
// Генерация счета...
// Отправка уведомления...
$orderFacade->placeOrder();
