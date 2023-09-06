<?php

declare(strict_types=1);

namespace Behavioral\Visitor;

/**
 * Паттерн Visitor.
 *
 * В этом примере паттерн Посетитель (Visitor) позволяет нам выполнять дополнительные операции,
 * не изменяя основной структуры классов Plane и Bus (транспортных средств).
 * Мы определяем интерфейс TransportVisitor, который содержит методы visitPlane() и visitBus(),
 * представляющие операции, которые нужно выполнить для каждого типа транспортного средства.
 *
 * Класс Airport содержит массив $transports, представляющий все доступные транспортные средства, и метод accept(),
 * который принимает объект TransportVisitor и вызывает соответствующий метод acceptVisitor() для каждого транспорта.
 *
 * Классы Plane и Bus реализуют интерфейс Transport и имеют метод acceptVisitor(),
 * который передает текущий объект TransportVisitor для выполнения операций посетителя.
 *
 * Для нашего примера мы создаем класс PriceCalculatorVisitor, который реализует интерфейс TransportVisitor.
 * Внутри этого класса определены операции visitPlane() и visitBus(), которые выполняют расчет стоимости для каждого типа транспортного средства.
 * Есть также метод getTotalPrice(), который возвращает общую стоимость всех транспортных средств.
 *
 * Наконец, мы создаем объект аэропорта, добавляем транспортные средства (самолеты и автобусы),
 * создаем посетителя для расчета стоимости и применяем его к аэропорту. После этого мы получаем общую стоимость и выводим ее на экран.
 *
 * Таким образом, паттерн Посетитель позволяет нам добавлять новые операции в классы транспортных средств, не изменяя их основную структуру,
 * а также отделяет операции от структуры классов, что обеспечивает гибкость и расширяемость системы.
 */
interface TransportVisitor
{
    public function visitPlane(Plane $plane): void;

    public function visitBus(Bus $bus): void;
}

class Airport
{
    /** @var list<Transport> */
    private array $transports = [];

    public function addTransport(Transport $transport): void
    {
        $this->transports[] = $transport;
    }

    public function accept(TransportVisitor $visitor): void
    {
        foreach ($this->transports as $transport) {
            $transport->acceptVisitor($visitor);
        }
    }
}

interface Transport
{
    public function acceptVisitor(TransportVisitor $visitor): void;
}

class Plane implements Transport
{
    public function acceptVisitor(TransportVisitor $visitor): void
    {
        $visitor->visitPlane($this);
    }
}

class Bus implements Transport
{
    public function acceptVisitor(TransportVisitor $visitor): void
    {
        $visitor->visitBus($this);
    }
}

class PriceCalculatorVisitor implements TransportVisitor
{
    private float $totalPrice = 0;

    public function visitPlane(Plane $plane): void
    {
        // Дополнительные операции для самолета, например, расчет стоимости билета
        $this->totalPrice += 100;
    }

    public function visitBus(Bus $bus): void
    {
        // Дополнительные операции для автобуса, например, расчет стоимости проезда
        $this->totalPrice += 10;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}

// Создаем аэропорт
$airport = new Airport();
$airport->addTransport(new Plane());
$airport->addTransport(new Bus());

// Создаем посетителя для расчета стоимости
$priceCalculator = new PriceCalculatorVisitor();

// Применяем посетителя к аэропорту
$airport->accept($priceCalculator);

// Получаем общую стоимость
echo "Total price: {$priceCalculator->getTotalPrice()}"; // Total price: 110
