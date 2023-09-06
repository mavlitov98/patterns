<?php

declare(strict_types=1);

namespace Structural\Decorator;

/**
 * Паттерн Decorator.
 *
 * В данном примере мы имеем транспортное средство в виде грузовика (Truck),
 * а затем мы применяем декораторы (CargoTrackingDecorator и DeliveryConfirmationDecorator),
 * чтобы добавить функциональность отслеживания груза и подтверждение доставки соответственно.
 * С начальным объектом грузовика мы последовательно применяем декораторы,
 * оборачивая его в каждый следующий декоратор и добавляя новые возможности.
 *
 * Таким образом, паттерн "Decorator" позволяет динамически добавлять новую функциональность к объектам,
 * оборачивая их в различные декораторы. Это полезно, когда нам нужно расширить функциональность объекта без изменения его основного класса.
 */

// Интерфейс, описывающий общие методы для всех транспортных средств
interface Transport
{
    public function trackShipping(): string;
}

// Основной класс, представляющий транспортное средство - грузовик
class Truck implements Transport
{
    public function trackShipping(): string
    {
        return "Отслеживание грузовика: отправка -> погрузка -> доставка";
    }
}

// Декоратор, который добавляет функциональность отслеживания груза
class CargoTrackingDecorator implements Transport
{
    public function __construct(
        protected Transport $transport,
    ) {
    }

    public function trackShipping(): string
    {
        return $this->transport->trackShipping() . " -> отслеживание груза";
    }
}

// Декоратор, который добавляет функциональность подтверждения доставки
class DeliveryConfirmationDecorator implements Transport
{
    public function __construct(
        protected Transport $transport,
    ) {
    }

    public function trackShipping(): string
    {
        return $this->transport->trackShipping() . " -> подтверждение доставки";
    }
}

// Создаем экземпляр грузовика
$truck = new Truck();

// Добавляем отслеживание груза к грузовику
$cargoTrackedTruck = new CargoTrackingDecorator($truck);

// Добавляем подтверждение доставки к грузовику с отслеживанием груза
$finalTransport = new DeliveryConfirmationDecorator($cargoTrackedTruck);

// Вызываем метод отслеживания для финального транспорта
// Отслеживание грузовика: отправка -> погрузка -> доставка -> отслеживание груза -> подтверждение доставки
var_dump($finalTransport->trackShipping());
